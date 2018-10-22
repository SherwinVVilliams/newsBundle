<?php
/**
 * Created by PhpStorm.
 * User: axharus
 * Date: 23-Jul-18
 * Time: 10:55
 */

namespace App\Helper\Geo;

define("GEOIP_COUNTRY_BEGIN", 16776960);
define("GEOIP_STATE_BEGIN_REV0", 16700000);
define("GEOIP_STATE_BEGIN_REV1", 16000000);
define("GEOIP_STANDARD", 0);
define("GEOIP_MEMORY_CACHE", 1);
define("GEOIP_SHARED_MEMORY", 2);
define("STRUCTURE_INFO_MAX_SIZE", 20);
define("DATABASE_INFO_MAX_SIZE", 100);
define("GEOIP_COUNTRY_EDITION", 1);
define("GEOIP_PROXY_EDITION", 8);
define("GEOIP_ASNUM_EDITION", 9);
define("GEOIP_NETSPEED_EDITION", 10);
define("GEOIP_REGION_EDITION_REV0", 7);
define("GEOIP_REGION_EDITION_REV1", 3);
define("GEOIP_CITY_EDITION_REV0", 6);
define("GEOIP_CITY_EDITION_REV1", 2);
define("GEOIP_ORG_EDITION", 5);
define("GEOIP_ISP_EDITION", 4);
define("SEGMENT_RECORD_LENGTH", 3);
define("STANDARD_RECORD_LENGTH", 3);
define("ORG_RECORD_LENGTH", 4);
define("MAX_RECORD_LENGTH", 4);
define("MAX_ORG_RECORD_LENGTH", 300);
define("GEOIP_SHM_KEY", 0x4f415401);
define("US_OFFSET", 1);
define("CANADA_OFFSET", 677);
define("WORLD_OFFSET", 1353);
define("FIPS_RANGE", 360);
define("GEOIP_UNKNOWN_SPEED", 0);
define("GEOIP_DIALUP_SPEED", 1);
define("GEOIP_CABLEDSL_SPEED", 2);
define("GEOIP_CORPORATE_SPEED", 3);
define("GEOIP_DOMAIN_EDITION", 11);
define("GEOIP_COUNTRY_EDITION_V6", 12);
define("GEOIP_LOCATIONA_EDITION", 13);
define("GEOIP_ACCURACYRADIUS_EDITION", 14);
define("GEOIP_CITYCOMBINED_EDITION", 15);
define("GEOIP_CITY_EDITION_REV1_V6", 30);
define("GEOIP_CITY_EDITION_REV0_V6", 31);
define("GEOIP_NETSPEED_EDITION_REV1", 32);
define("GEOIP_NETSPEED_EDITION_REV1_V6", 33);
define("GEOIP_USERTYPE_EDITION", 28);
define("GEOIP_USERTYPE_EDITION_V6", 29);
define("GEOIP_ASNUM_EDITION_V6", 21);
define("GEOIP_ISP_EDITION_V6", 22);
define("GEOIP_ORG_EDITION_V6", 23);
define("GEOIP_DOMAIN_EDITION_V6", 24);

define("CITYCOMBINED_FIXED_RECORD", 7);


class GeoByIp {
	public function getClientCountry() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			$ip=$_SERVER['REMOTE_ADDR'];
		}

		$gi = $this->geoip_open(__DIR__."/GeoIP.dat",GEOIP_STANDARD);
		$result = $this->geoip_country_name_by_addr($gi, $ip);
		return $result;
	}

	public function geoip_load_shared_mem($file)
	{
		$fp = fopen($file, "rb");
		if (!$fp) {
			print "error opening $file: $php_errormsg\n";
			exit;
		}
		$s_array = fstat($fp);
		$size = $s_array['size'];
		if (($shmid = @shmop_open(GEOIP_SHM_KEY, "w", 0, 0))) {
			shmop_delete($shmid);
			shmop_close($shmid);
		}
		$shmid = shmop_open(GEOIP_SHM_KEY, "c", 0644, $size);
		shmop_write($shmid, fread($fp, $size), 0);
		shmop_close($shmid);
	}

	public function _setup_segments($gi)
	{
		$gi->databaseType = GEOIP_COUNTRY_EDITION;
		$gi->record_length = STANDARD_RECORD_LENGTH;
		if ($gi->flags & GEOIP_SHARED_MEMORY) {
			$offset = @shmop_size($gi->shmid) - 3;
			for ($i = 0; $i < STRUCTURE_INFO_MAX_SIZE; $i++) {
				$delim = @shmop_read($gi->shmid, $offset, 3);
				$offset += 3;
				if ($delim == (chr(255) . chr(255) . chr(255))) {
					$gi->databaseType = ord(@shmop_read($gi->shmid, $offset, 1));
					if ($gi->databaseType >= 106) {
						$gi->databaseType -= 105;
					}
					$offset++;

					if ($gi->databaseType == GEOIP_REGION_EDITION_REV0) {
						$gi->databaseSegments = GEOIP_STATE_BEGIN_REV0;
					} elseif ($gi->databaseType == GEOIP_REGION_EDITION_REV1) {
						$gi->databaseSegments = GEOIP_STATE_BEGIN_REV1;
					} elseif (($gi->databaseType == GEOIP_CITY_EDITION_REV0)
					          || ($gi->databaseType == GEOIP_CITY_EDITION_REV1)
					          || ($gi->databaseType == GEOIP_ORG_EDITION)
					          || ($gi->databaseType == GEOIP_ORG_EDITION_V6)
					          || ($gi->databaseType == GEOIP_DOMAIN_EDITION)
					          || ($gi->databaseType == GEOIP_DOMAIN_EDITION_V6)
					          || ($gi->databaseType == GEOIP_ISP_EDITION)
					          || ($gi->databaseType == GEOIP_ISP_EDITION_V6)
					          || ($gi->databaseType == GEOIP_USERTYPE_EDITION)
					          || ($gi->databaseType == GEOIP_USERTYPE_EDITION_V6)
					          || ($gi->databaseType == GEOIP_LOCATIONA_EDITION)
					          || ($gi->databaseType == GEOIP_ACCURACYRADIUS_EDITION)
					          || ($gi->databaseType == GEOIP_CITY_EDITION_REV0_V6)
					          || ($gi->databaseType == GEOIP_CITY_EDITION_REV1_V6)
					          || ($gi->databaseType == GEOIP_NETSPEED_EDITION_REV1)
					          || ($gi->databaseType == GEOIP_NETSPEED_EDITION_REV1_V6)
					          || ($gi->databaseType == GEOIP_ASNUM_EDITION)
					          || ($gi->databaseType == GEOIP_ASNUM_EDITION_V6)
					) {
						$gi->databaseSegments = 0;
						$buf = @shmop_read($gi->shmid, $offset, SEGMENT_RECORD_LENGTH);
						for ($j = 0; $j < SEGMENT_RECORD_LENGTH; $j++) {
							$gi->databaseSegments += (ord($buf[$j]) << ($j * 8));
						}
						if (($gi->databaseType == GEOIP_ORG_EDITION)
						    || ($gi->databaseType == GEOIP_ORG_EDITION_V6)
						    || ($gi->databaseType == GEOIP_DOMAIN_EDITION)
						    || ($gi->databaseType == GEOIP_DOMAIN_EDITION_V6)
						    || ($gi->databaseType == GEOIP_ISP_EDITION)
						    || ($gi->databaseType == GEOIP_ISP_EDITION_V6)
						) {
							$gi->record_length = ORG_RECORD_LENGTH;
						}
					}
					break;
				} else {
					$offset -= 4;
				}
			}
			if (($gi->databaseType == GEOIP_COUNTRY_EDITION) ||
			    ($gi->databaseType == GEOIP_COUNTRY_EDITION_V6) ||
			    ($gi->databaseType == GEOIP_PROXY_EDITION) ||
			    ($gi->databaseType == GEOIP_NETSPEED_EDITION)
			) {
				$gi->databaseSegments = GEOIP_COUNTRY_BEGIN;
			}
		} else {
			$filepos = ftell($gi->filehandle);
			fseek($gi->filehandle, -3, SEEK_END);
			for ($i = 0; $i < STRUCTURE_INFO_MAX_SIZE; $i++) {
				$delim = fread($gi->filehandle, 3);
				if ($delim == (chr(255) . chr(255) . chr(255))) {
					$gi->databaseType = ord(fread($gi->filehandle, 1));
					if ($gi->databaseType >= 106) {
						$gi->databaseType -= 105;
					}
					if ($gi->databaseType == GEOIP_REGION_EDITION_REV0) {
						$gi->databaseSegments = GEOIP_STATE_BEGIN_REV0;
					} elseif ($gi->databaseType == GEOIP_REGION_EDITION_REV1) {
						$gi->databaseSegments = GEOIP_STATE_BEGIN_REV1;
					} elseif (($gi->databaseType == GEOIP_CITY_EDITION_REV0)
					          || ($gi->databaseType == GEOIP_CITY_EDITION_REV1)
					          || ($gi->databaseType == GEOIP_CITY_EDITION_REV0_V6)
					          || ($gi->databaseType == GEOIP_CITY_EDITION_REV1_V6)
					          || ($gi->databaseType == GEOIP_ORG_EDITION)
					          || ($gi->databaseType == GEOIP_DOMAIN_EDITION)
					          || ($gi->databaseType == GEOIP_ISP_EDITION)
					          || ($gi->databaseType == GEOIP_ORG_EDITION_V6)
					          || ($gi->databaseType == GEOIP_DOMAIN_EDITION_V6)
					          || ($gi->databaseType == GEOIP_ISP_EDITION_V6)
					          || ($gi->databaseType == GEOIP_LOCATIONA_EDITION)
					          || ($gi->databaseType == GEOIP_ACCURACYRADIUS_EDITION)
					          || ($gi->databaseType == GEOIP_CITY_EDITION_REV0_V6)
					          || ($gi->databaseType == GEOIP_CITY_EDITION_REV1_V6)
					          || ($gi->databaseType == GEOIP_NETSPEED_EDITION_REV1)
					          || ($gi->databaseType == GEOIP_NETSPEED_EDITION_REV1_V6)
					          || ($gi->databaseType == GEOIP_USERTYPE_EDITION)
					          || ($gi->databaseType == GEOIP_USERTYPE_EDITION_V6)
					          || ($gi->databaseType == GEOIP_ASNUM_EDITION)
					          || ($gi->databaseType == GEOIP_ASNUM_EDITION_V6)
					) {
						$gi->databaseSegments = 0;
						$buf = fread($gi->filehandle, SEGMENT_RECORD_LENGTH);
						for ($j = 0; $j < SEGMENT_RECORD_LENGTH; $j++) {
							$gi->databaseSegments += (ord($buf[$j]) << ($j * 8));
						}
						if (($gi->databaseType == GEOIP_ORG_EDITION)
						    || ($gi->databaseType == GEOIP_DOMAIN_EDITION)
						    || ($gi->databaseType == GEOIP_ISP_EDITION)
						    || ($gi->databaseType == GEOIP_ORG_EDITION_V6)
						    || ($gi->databaseType == GEOIP_DOMAIN_EDITION_V6)
						    || ($gi->databaseType == GEOIP_ISP_EDITION_V6)
						) {
							$gi->record_length = ORG_RECORD_LENGTH;
						}
					}
					break;
				} else {
					fseek($gi->filehandle, -4, SEEK_CUR);
				}
			}
			if (($gi->databaseType == GEOIP_COUNTRY_EDITION) ||
			    ($gi->databaseType == GEOIP_COUNTRY_EDITION_V6) ||
			    ($gi->databaseType == GEOIP_PROXY_EDITION) ||
			    ($gi->databaseType == GEOIP_NETSPEED_EDITION)
			) {
				$gi->databaseSegments = GEOIP_COUNTRY_BEGIN;
			}
			fseek($gi->filehandle, $filepos, SEEK_SET);
		}
		return $gi;
	}

	public function geoip_open($filename, $flags)
	{
		$gi = new GeoIP;
		$gi->flags = $flags;
		if ($gi->flags & GEOIP_SHARED_MEMORY) {
			$gi->shmid = @shmop_open(GEOIP_SHM_KEY, "a", 0, 0);
		} else {
			$gi->filehandle = fopen($filename, "rb") or die("Can not open $filename\n");
			if ($gi->flags & GEOIP_MEMORY_CACHE) {
				$s_array = fstat($gi->filehandle);
				$gi->memory_buffer = fread($gi->filehandle, $s_array['size']);
			}
		}

		$gi = $this->_setup_segments($gi);
		return $gi;
	}

	public function geoip_close($gi)
	{
		if ($gi->flags & GEOIP_SHARED_MEMORY) {
			return true;
		}

		return fclose($gi->filehandle);
	}

	public function geoip_country_id_by_name_v6($gi, $name)
	{
		$rec = dns_get_record($name, DNS_AAAA);
		if (!$rec) {
			return false;
		}
		$addr = $rec[0]["ipv6"];
		if (!$addr || $addr == $name) {
			return false;
		}
		return $this->geoip_country_id_by_addr_v6($gi, $addr);
	}

	public function geoip_country_id_by_name($gi, $name)
	{
		$addr = gethostbyname($name);
		if (!$addr || $addr == $name) {
			return false;
		}
		return $this->geoip_country_id_by_addr($gi, $addr);
	}

	public function geoip_country_code_by_name_v6($gi, $name)
	{
		$country_id = $this->geoip_country_id_by_name_v6($gi, $name);
		if ($country_id !== false) {
			return $gi->GEOIP_COUNTRY_CODES[$country_id];
		}
		return false;
	}

	public function geoip_country_code_by_name($gi, $name)
	{
		$country_id = $this->geoip_country_id_by_name($gi, $name);
		if ($country_id !== false) {
			return $gi->GEOIP_COUNTRY_CODES[$country_id];
		}
		return false;
	}

	public function geoip_country_name_by_name_v6($gi, $name)
	{
		$country_id = $this->geoip_country_id_by_name_v6($gi, $name);
		if ($country_id !== false) {
			return $gi->GEOIP_COUNTRY_NAMES[$country_id];
		}
		return false;
	}

	public function geoip_country_name_by_name($gi, $name)
	{
		$country_id = $this->geoip_country_id_by_name($gi, $name);
		if ($country_id !== false) {
			return $gi->GEOIP_COUNTRY_NAMES[$country_id];
		}
		return false;
	}

	public function geoip_country_id_by_addr_v6($gi, $addr)
	{
		$ipnum = inet_pton($addr);
		return $this->_geoip_seek_country_v6($gi, $ipnum) - GEOIP_COUNTRY_BEGIN;
	}

	public function geoip_country_id_by_addr($gi, $addr)
	{
		$ipnum = ip2long($addr);
		return $this->_geoip_seek_country($gi, $ipnum) - GEOIP_COUNTRY_BEGIN;
	}

	public function geoip_country_code_by_addr_v6($gi, $addr)
	{
		$country_id = $this->geoip_country_id_by_addr_v6($gi, $addr);
		if ($country_id !== false) {
			return $gi->GEOIP_COUNTRY_CODES[$country_id];
		}
		return false;
	}

	public function geoip_country_code_by_addr($gi, $addr)
	{
		if ($gi->databaseType == GEOIP_CITY_EDITION_REV1) {
			$record = $this->geoip_record_by_addr($gi, $addr);
			if ($record !== false) {
				return $record->country_code;
			}
		} else {
			$country_id = $this->geoip_country_id_by_addr($gi, $addr);
			if ($country_id !== false) {
				return $gi->GEOIP_COUNTRY_CODES[$country_id];
			}
		}
		return false;
	}

	public function geoip_country_name_by_addr_v6($gi, $addr)
	{
		$country_id = $this->geoip_country_id_by_addr_v6($gi, $addr);
		if ($country_id !== false) {
			return $gi->GEOIP_COUNTRY_NAMES[$country_id];
		}
		return false;
	}

	public function geoip_country_name_by_addr($gi, $addr)
	{
		if ($gi->databaseType == GEOIP_CITY_EDITION_REV1) {
			$record = $this->geoip_record_by_addr($gi, $addr);
			return $record->country_name;
		} else {
			$country_id = $this->geoip_country_id_by_addr($gi, $addr);
			if ($country_id !== false) {
				return $gi->GEOIP_COUNTRY_NAMES[$country_id];
			}
		}
		return false;
	}

	public function _geoip_seek_country_v6($gi, $ipnum)
	{
		# arrays from unpack start with offset 1
		# yet another php mystery. array_merge work around
		# this broken behaviour
		$v6vec = array_merge(unpack("C16", $ipnum));

		$offset = 0;
		for ($depth = 127; $depth >= 0; --$depth) {
			if ($gi->flags & GEOIP_MEMORY_CACHE) {
				$buf = _safe_substr(
					$gi->memory_buffer,
					2 * $gi->record_length * $offset,
					2 * $gi->record_length
				);
			} elseif ($gi->flags & GEOIP_SHARED_MEMORY) {
				$buf = @shmop_read(
					$gi->shmid,
					2 * $gi->record_length * $offset,
					2 * $gi->record_length
				);
			} else {
				fseek($gi->filehandle, 2 * $gi->record_length * $offset, SEEK_SET) == 0
				or die("fseek failed");
				$buf = fread($gi->filehandle, 2 * $gi->record_length);
			}
			$x = array(0, 0);
			for ($i = 0; $i < 2; ++$i) {
				for ($j = 0; $j < $gi->record_length; ++$j) {
					$x[$i] += ord($buf[$gi->record_length * $i + $j]) << ($j * 8);
				}
			}

			$bnum = 127 - $depth;
			$idx = $bnum >> 3;
			$b_mask = 1 << ($bnum & 7 ^ 7);
			if (($v6vec[$idx] & $b_mask) > 0) {
				if ($x[1] >= $gi->databaseSegments) {
					return $x[1];
				}
				$offset = $x[1];
			} else {
				if ($x[0] >= $gi->databaseSegments) {
					return $x[0];
				}
				$offset = $x[0];
			}
		}
		trigger_error("error traversing database - perhaps it is corrupt?", E_USER_ERROR);
		return false;
	}

	public function _geoip_seek_country($gi, $ipnum)
	{
		$offset = 0;
		for ($depth = 31; $depth >= 0; --$depth) {
			if ($gi->flags & GEOIP_MEMORY_CACHE) {
				$buf = _safe_substr(
					$gi->memory_buffer,
					2 * $gi->record_length * $offset,
					2 * $gi->record_length
				);
			} elseif ($gi->flags & GEOIP_SHARED_MEMORY) {
				$buf = @shmop_read(
					$gi->shmid,
					2 * $gi->record_length * $offset,
					2 * $gi->record_length
				);
			} else {
				fseek($gi->filehandle, 2 * $gi->record_length * $offset, SEEK_SET) == 0
				or die("fseek failed");
				$buf = fread($gi->filehandle, 2 * $gi->record_length);
			}
			$x = array(0, 0);
			for ($i = 0; $i < 2; ++$i) {
				for ($j = 0; $j < $gi->record_length; ++$j) {
					$x[$i] += ord($buf[$gi->record_length * $i + $j]) << ($j * 8);
				}
			}
			if ($ipnum & (1 << $depth)) {
				if ($x[1] >= $gi->databaseSegments) {
					return $x[1];
				}
				$offset = $x[1];
			} else {
				if ($x[0] >= $gi->databaseSegments) {
					return $x[0];
				}
				$offset = $x[0];
			}
		}
		trigger_error("error traversing database - perhaps it is corrupt?", E_USER_ERROR);
		return false;
	}

	public function _common_get_org($gi, $seek_org)
	{
		$record_pointer = $seek_org + (2 * $gi->record_length - 1) * $gi->databaseSegments;
		if ($gi->flags & GEOIP_SHARED_MEMORY) {
			$org_buf = @shmop_read($gi->shmid, $record_pointer, MAX_ORG_RECORD_LENGTH);
		} else {
			fseek($gi->filehandle, $record_pointer, SEEK_SET);
			$org_buf = fread($gi->filehandle, MAX_ORG_RECORD_LENGTH);
		}
		$org_buf = _safe_substr($org_buf, 0, strpos($org_buf, "\0"));
		return $org_buf;
	}

	public function _get_org_v6($gi, $ipnum)
	{
		$seek_org = _geoip_seek_country_v6($gi, $ipnum);
		if ($seek_org == $gi->databaseSegments) {
			return null;
		}
		return _common_get_org($gi, $seek_org);
	}

	public function _get_org($gi, $ipnum)
	{
		$seek_org = _geoip_seek_country($gi, $ipnum);
		if ($seek_org == $gi->databaseSegments) {
			return null;
		}
		return _common_get_org($gi, $seek_org);
	}


	public function geoip_name_by_addr_v6($gi, $addr)
	{
		if ($addr == null) {
			return 0;
		}
		$ipnum = inet_pton($addr);
		return _get_org_v6($gi, $ipnum);
	}

	public function geoip_name_by_addr($gi, $addr)
	{
		if ($addr == null) {
			return 0;
		}
		$ipnum = ip2long($addr);
		return _get_org($gi, $ipnum);
	}

	public function geoip_org_by_addr($gi, $addr)
	{
		return $this->geoip_name_by_addr($gi, $addr);
	}

	public function _get_region($gi, $ipnum)
	{
		if ($gi->databaseType == GEOIP_REGION_EDITION_REV0) {
			$seek_region = _geoip_seek_country($gi, $ipnum) - GEOIP_STATE_BEGIN_REV0;
			if ($seek_region >= 1000) {
				$country_code = "US";
				$region = chr(($seek_region - 1000) / 26 + 65) . chr(($seek_region - 1000) % 26 + 65);
			} else {
				$country_code = $gi->GEOIP_COUNTRY_CODES[$seek_region];
				$region = "";
			}
			return array($country_code, $region);
		} elseif ($gi->databaseType == GEOIP_REGION_EDITION_REV1) {
			$seek_region = _geoip_seek_country($gi, $ipnum) - GEOIP_STATE_BEGIN_REV1;
			if ($seek_region < US_OFFSET) {
				$country_code = "";
				$region = "";
			} elseif ($seek_region < CANADA_OFFSET) {
				$country_code = "US";
				$region = chr(($seek_region - US_OFFSET) / 26 + 65) . chr(($seek_region - US_OFFSET) % 26 + 65);
			} elseif ($seek_region < WORLD_OFFSET) {
				$country_code = "CA";
				$region = chr(($seek_region - CANADA_OFFSET) / 26 + 65) . chr(($seek_region - CANADA_OFFSET) % 26 + 65);
			} else {
				$country_code = $gi->GEOIP_COUNTRY_CODES[($seek_region - WORLD_OFFSET) / FIPS_RANGE];
				$region = "";
			}
			return array($country_code, $region);
		}
	}

	public function geoip_region_by_addr($gi, $addr)
	{
		if ($addr == null) {
			return 0;
		}
		$ipnum = ip2long($addr);
		return _get_region($gi, $ipnum);
	}

	public function _safe_substr($string, $start, $length)
	{
		// workaround php's broken substr, strpos, etc handling with
		// mbstring.func_overload and mbstring.internal_encoding
		$mbExists = extension_loaded('mbstring');

		if ($mbExists) {
			$enc = mb_internal_encoding();
			mb_internal_encoding('ISO-8859-1');
		}

		$buf = substr($string, $start, $length);

		if ($mbExists) {
			mb_internal_encoding($enc);
		}

		return $buf;
	}
}

class GeoIP
{
	public $flags;
	public $filehandle;
	public $memory_buffer;
	public $databaseType;
	public $databaseSegments;
	public $record_length;
	public $shmid;
	public $GEOIP_COUNTRY_CODE_TO_NUMBER = array(
		"" => 0,
		"AP" => 1,
		"EU" => 2,
		"AD" => 3,
		"AE" => 4,
		"AF" => 5,
		"AG" => 6,
		"AI" => 7,
		"AL" => 8,
		"AM" => 9,
		"CW" => 10,
		"AO" => 11,
		"AQ" => 12,
		"AR" => 13,
		"AS" => 14,
		"AT" => 15,
		"AU" => 16,
		"AW" => 17,
		"AZ" => 18,
		"BA" => 19,
		"BB" => 20,
		"BD" => 21,
		"BE" => 22,
		"BF" => 23,
		"BG" => 24,
		"BH" => 25,
		"BI" => 26,
		"BJ" => 27,
		"BM" => 28,
		"BN" => 29,
		"BO" => 30,
		"BR" => 31,
		"BS" => 32,
		"BT" => 33,
		"BV" => 34,
		"BW" => 35,
		"BY" => 36,
		"BZ" => 37,
		"CA" => 38,
		"CC" => 39,
		"CD" => 40,
		"CF" => 41,
		"CG" => 42,
		"CH" => 43,
		"CI" => 44,
		"CK" => 45,
		"CL" => 46,
		"CM" => 47,
		"CN" => 48,
		"CO" => 49,
		"CR" => 50,
		"CU" => 51,
		"CV" => 52,
		"CX" => 53,
		"CY" => 54,
		"CZ" => 55,
		"DE" => 56,
		"DJ" => 57,
		"DK" => 58,
		"DM" => 59,
		"DO" => 60,
		"DZ" => 61,
		"EC" => 62,
		"EE" => 63,
		"EG" => 64,
		"EH" => 65,
		"ER" => 66,
		"ES" => 67,
		"ET" => 68,
		"FI" => 69,
		"FJ" => 70,
		"FK" => 71,
		"FM" => 72,
		"FO" => 73,
		"FR" => 74,
		"SX" => 75,
		"GA" => 76,
		"GB" => 77,
		"GD" => 78,
		"GE" => 79,
		"GF" => 80,
		"GH" => 81,
		"GI" => 82,
		"GL" => 83,
		"GM" => 84,
		"GN" => 85,
		"GP" => 86,
		"GQ" => 87,
		"GR" => 88,
		"GS" => 89,
		"GT" => 90,
		"GU" => 91,
		"GW" => 92,
		"GY" => 93,
		"HK" => 94,
		"HM" => 95,
		"HN" => 96,
		"HR" => 97,
		"HT" => 98,
		"HU" => 99,
		"ID" => 100,
		"IE" => 101,
		"IL" => 102,
		"IN" => 103,
		"IO" => 104,
		"IQ" => 105,
		"IR" => 106,
		"IS" => 107,
		"IT" => 108,
		"JM" => 109,
		"JO" => 110,
		"JP" => 111,
		"KE" => 112,
		"KG" => 113,
		"KH" => 114,
		"KI" => 115,
		"KM" => 116,
		"KN" => 117,
		"KP" => 118,
		"KR" => 119,
		"KW" => 120,
		"KY" => 121,
		"KZ" => 122,
		"LA" => 123,
		"LB" => 124,
		"LC" => 125,
		"LI" => 126,
		"LK" => 127,
		"LR" => 128,
		"LS" => 129,
		"LT" => 130,
		"LU" => 131,
		"LV" => 132,
		"LY" => 133,
		"MA" => 134,
		"MC" => 135,
		"MD" => 136,
		"MG" => 137,
		"MH" => 138,
		"MK" => 139,
		"ML" => 140,
		"MM" => 141,
		"MN" => 142,
		"MO" => 143,
		"MP" => 144,
		"MQ" => 145,
		"MR" => 146,
		"MS" => 147,
		"MT" => 148,
		"MU" => 149,
		"MV" => 150,
		"MW" => 151,
		"MX" => 152,
		"MY" => 153,
		"MZ" => 154,
		"NA" => 155,
		"NC" => 156,
		"NE" => 157,
		"NF" => 158,
		"NG" => 159,
		"NI" => 160,
		"NL" => 161,
		"NO" => 162,
		"NP" => 163,
		"NR" => 164,
		"NU" => 165,
		"NZ" => 166,
		"OM" => 167,
		"PA" => 168,
		"PE" => 169,
		"PF" => 170,
		"PG" => 171,
		"PH" => 172,
		"PK" => 173,
		"PL" => 174,
		"PM" => 175,
		"PN" => 176,
		"PR" => 177,
		"PS" => 178,
		"PT" => 179,
		"PW" => 180,
		"PY" => 181,
		"QA" => 182,
		"RE" => 183,
		"RO" => 184,
		"RU" => 185,
		"RW" => 186,
		"SA" => 187,
		"SB" => 188,
		"SC" => 189,
		"SD" => 190,
		"SE" => 191,
		"SG" => 192,
		"SH" => 193,
		"SI" => 194,
		"SJ" => 195,
		"SK" => 196,
		"SL" => 197,
		"SM" => 198,
		"SN" => 199,
		"SO" => 200,
		"SR" => 201,
		"ST" => 202,
		"SV" => 203,
		"SY" => 204,
		"SZ" => 205,
		"TC" => 206,
		"TD" => 207,
		"TF" => 208,
		"TG" => 209,
		"TH" => 210,
		"TJ" => 211,
		"TK" => 212,
		"TM" => 213,
		"TN" => 214,
		"TO" => 215,
		"TL" => 216,
		"TR" => 217,
		"TT" => 218,
		"TV" => 219,
		"TW" => 220,
		"TZ" => 221,
		"UA" => 222,
		"UG" => 223,
		"UM" => 224,
		"US" => 225,
		"UY" => 226,
		"UZ" => 227,
		"VA" => 228,
		"VC" => 229,
		"VE" => 230,
		"VG" => 231,
		"VI" => 232,
		"VN" => 233,
		"VU" => 234,
		"WF" => 235,
		"WS" => 236,
		"YE" => 237,
		"YT" => 238,
		"RS" => 239,
		"ZA" => 240,
		"ZM" => 241,
		"ME" => 242,
		"ZW" => 243,
		"A1" => 244,
		"A2" => 245,
		"O1" => 246,
		"AX" => 247,
		"GG" => 248,
		"IM" => 249,
		"JE" => 250,
		"BL" => 251,
		"MF" => 252,
		"BQ" => 253,
		"SS" => 254
	);

	public $GEOIP_COUNTRY_CODES = array(
		"",
		"AP",
		"EU",
		"AD",
		"AE",
		"AF",
		"AG",
		"AI",
		"AL",
		"AM",
		"CW",
		"AO",
		"AQ",
		"AR",
		"AS",
		"AT",
		"AU",
		"AW",
		"AZ",
		"BA",
		"BB",
		"BD",
		"BE",
		"BF",
		"BG",
		"BH",
		"BI",
		"BJ",
		"BM",
		"BN",
		"BO",
		"BR",
		"BS",
		"BT",
		"BV",
		"BW",
		"BY",
		"BZ",
		"CA",
		"CC",
		"CD",
		"CF",
		"CG",
		"CH",
		"CI",
		"CK",
		"CL",
		"CM",
		"CN",
		"CO",
		"CR",
		"CU",
		"CV",
		"CX",
		"CY",
		"CZ",
		"DE",
		"DJ",
		"DK",
		"DM",
		"DO",
		"DZ",
		"EC",
		"EE",
		"EG",
		"EH",
		"ER",
		"ES",
		"ET",
		"FI",
		"FJ",
		"FK",
		"FM",
		"FO",
		"FR",
		"SX",
		"GA",
		"GB",
		"GD",
		"GE",
		"GF",
		"GH",
		"GI",
		"GL",
		"GM",
		"GN",
		"GP",
		"GQ",
		"GR",
		"GS",
		"GT",
		"GU",
		"GW",
		"GY",
		"HK",
		"HM",
		"HN",
		"HR",
		"HT",
		"HU",
		"ID",
		"IE",
		"IL",
		"IN",
		"IO",
		"IQ",
		"IR",
		"IS",
		"IT",
		"JM",
		"JO",
		"JP",
		"KE",
		"KG",
		"KH",
		"KI",
		"KM",
		"KN",
		"KP",
		"KR",
		"KW",
		"KY",
		"KZ",
		"LA",
		"LB",
		"LC",
		"LI",
		"LK",
		"LR",
		"LS",
		"LT",
		"LU",
		"LV",
		"LY",
		"MA",
		"MC",
		"MD",
		"MG",
		"MH",
		"MK",
		"ML",
		"MM",
		"MN",
		"MO",
		"MP",
		"MQ",
		"MR",
		"MS",
		"MT",
		"MU",
		"MV",
		"MW",
		"MX",
		"MY",
		"MZ",
		"NA",
		"NC",
		"NE",
		"NF",
		"NG",
		"NI",
		"NL",
		"NO",
		"NP",
		"NR",
		"NU",
		"NZ",
		"OM",
		"PA",
		"PE",
		"PF",
		"PG",
		"PH",
		"PK",
		"PL",
		"PM",
		"PN",
		"PR",
		"PS",
		"PT",
		"PW",
		"PY",
		"QA",
		"RE",
		"RO",
		"RU",
		"RW",
		"SA",
		"SB",
		"SC",
		"SD",
		"SE",
		"SG",
		"SH",
		"SI",
		"SJ",
		"SK",
		"SL",
		"SM",
		"SN",
		"SO",
		"SR",
		"ST",
		"SV",
		"SY",
		"SZ",
		"TC",
		"TD",
		"TF",
		"TG",
		"TH",
		"TJ",
		"TK",
		"TM",
		"TN",
		"TO",
		"TL",
		"TR",
		"TT",
		"TV",
		"TW",
		"TZ",
		"UA",
		"UG",
		"UM",
		"US",
		"UY",
		"UZ",
		"VA",
		"VC",
		"VE",
		"VG",
		"VI",
		"VN",
		"VU",
		"WF",
		"WS",
		"YE",
		"YT",
		"RS",
		"ZA",
		"ZM",
		"ME",
		"ZW",
		"A1",
		"A2",
		"O1",
		"AX",
		"GG",
		"IM",
		"JE",
		"BL",
		"MF",
		"BQ",
		"SS",
		"O1"
	);

	public $GEOIP_COUNTRY_CODES3 = array(
		"",
		"AP",
		"EU",
		"AND",
		"ARE",
		"AFG",
		"ATG",
		"AIA",
		"ALB",
		"ARM",
		"CUW",
		"AGO",
		"ATA",
		"ARG",
		"ASM",
		"AUT",
		"AUS",
		"ABW",
		"AZE",
		"BIH",
		"BRB",
		"BGD",
		"BEL",
		"BFA",
		"BGR",
		"BHR",
		"BDI",
		"BEN",
		"BMU",
		"BRN",
		"BOL",
		"BRA",
		"BHS",
		"BTN",
		"BVT",
		"BWA",
		"BLR",
		"BLZ",
		"CAN",
		"CCK",
		"COD",
		"CAF",
		"COG",
		"CHE",
		"CIV",
		"COK",
		"CHL",
		"CMR",
		"CHN",
		"COL",
		"CRI",
		"CUB",
		"CPV",
		"CXR",
		"CYP",
		"CZE",
		"DEU",
		"DJI",
		"DNK",
		"DMA",
		"DOM",
		"DZA",
		"ECU",
		"EST",
		"EGY",
		"ESH",
		"ERI",
		"ESP",
		"ETH",
		"FIN",
		"FJI",
		"FLK",
		"FSM",
		"FRO",
		"FRA",
		"SXM",
		"GAB",
		"GBR",
		"GRD",
		"GEO",
		"GUF",
		"GHA",
		"GIB",
		"GRL",
		"GMB",
		"GIN",
		"GLP",
		"GNQ",
		"GRC",
		"SGS",
		"GTM",
		"GUM",
		"GNB",
		"GUY",
		"HKG",
		"HMD",
		"HND",
		"HRV",
		"HTI",
		"HUN",
		"IDN",
		"IRL",
		"ISR",
		"IND",
		"IOT",
		"IRQ",
		"IRN",
		"ISL",
		"ITA",
		"JAM",
		"JOR",
		"JPN",
		"KEN",
		"KGZ",
		"KHM",
		"KIR",
		"COM",
		"KNA",
		"PRK",
		"KOR",
		"KWT",
		"CYM",
		"KAZ",
		"LAO",
		"LBN",
		"LCA",
		"LIE",
		"LKA",
		"LBR",
		"LSO",
		"LTU",
		"LUX",
		"LVA",
		"LBY",
		"MAR",
		"MCO",
		"MDA",
		"MDG",
		"MHL",
		"MKD",
		"MLI",
		"MMR",
		"MNG",
		"MAC",
		"MNP",
		"MTQ",
		"MRT",
		"MSR",
		"MLT",
		"MUS",
		"MDV",
		"MWI",
		"MEX",
		"MYS",
		"MOZ",
		"NAM",
		"NCL",
		"NER",
		"NFK",
		"NGA",
		"NIC",
		"NLD",
		"NOR",
		"NPL",
		"NRU",
		"NIU",
		"NZL",
		"OMN",
		"PAN",
		"PER",
		"PYF",
		"PNG",
		"PHL",
		"PAK",
		"POL",
		"SPM",
		"PCN",
		"PRI",
		"PSE",
		"PRT",
		"PLW",
		"PRY",
		"QAT",
		"REU",
		"ROU",
		"RUS",
		"RWA",
		"SAU",
		"SLB",
		"SYC",
		"SDN",
		"SWE",
		"SGP",
		"SHN",
		"SVN",
		"SJM",
		"SVK",
		"SLE",
		"SMR",
		"SEN",
		"SOM",
		"SUR",
		"STP",
		"SLV",
		"SYR",
		"SWZ",
		"TCA",
		"TCD",
		"ATF",
		"TGO",
		"THA",
		"TJK",
		"TKL",
		"TKM",
		"TUN",
		"TON",
		"TLS",
		"TUR",
		"TTO",
		"TUV",
		"TWN",
		"TZA",
		"UKR",
		"UGA",
		"UMI",
		"USA",
		"URY",
		"UZB",
		"VAT",
		"VCT",
		"VEN",
		"VGB",
		"VIR",
		"VNM",
		"VUT",
		"WLF",
		"WSM",
		"YEM",
		"MYT",
		"SRB",
		"ZAF",
		"ZMB",
		"MNE",
		"ZWE",
		"A1",
		"A2",
		"O1",
		"ALA",
		"GGY",
		"IMN",
		"JEY",
		"BLM",
		"MAF",
		"BES",
		"SSD",
		"O1"
	);

	public $GEOIP_COUNTRY_NAMES = array(
		"во всех странах",
		"в Азии",
		"в Европе",
		"в Андорре",
		"в Объединенных Арабских Эмиратах",
		"в Афганистане",
		"в Антигуа и Барбуде",
		"в Ангилье",
		"в Албании",
		"в Армении",
		"в Кюрасао",
		"в Анголе",
		"в Антарктике",
		"в Аргентине",
		"в Американском Самоа",
		"в Австрии",
		"в Австралии",
		"в Арубе",
		"в Азербайджане",
		"в Боснии и Герцеговине",
		"в Барбадосе",
		"в Бангладеше",
		"в Бельгии",
		"в Буркина-Фасо",
		"в Болгарии",
		"в Бахрейне",
		"в Бурунди",
		"в Бенине",
		"на Бермудах",
		"в Бруней-Даруссаламе",
		"в Боливии",
		"в Бразилии",
		"на Багамских Островах",
		"в Бутане",
		"Остров Буве",
		"в Ботсване",
		"в Беларуси",
		"в Белизе",
		"в Канаде",
		"на Кокосовых островах",
		"в Конго",
		"в Центрально-Африканской Республике",
		"в Конго",
		"в Швейцарии",
		"в Кот-д'Ивуаре",
		"на Островах Кука",
		"в Чили",
		"в Камеруне",
		"в Китае",
		"в Колумбии",
		"в Косте-Рике",
		"на Кубе",
		"в Кабо-Верде",
		"на Острове Рождества",
		"на Кипре",
		"в Чешской Республике",
		"в Германии",
		"в Джибути",
		"в Дании",
		"в Доминике",
		"в Доминиканской Республике",
		"в Алжире",
		"в Эквадоре",
		"в Эстонии",
		"в Египте",
		"в Западной Сахаре",
		"в Эритрее",
		"в Испании",
		"в Эфиопии",
		"в Финляндии",
		"в Фиджи",
		"на Фолклендских островах",
		"в Федеративных Штатах Микронезии",
		"на Фарерских островах",
		"в Франции",
		"в Синт-Маартене",
		"в Габоне",
		"в Великобритании",
		"в Гренаде",
		"в Грузии",
		"в Французской Гвиане",
		"в Гане",
		"в Гибралтаре",
		"в Гренландии",
		"в Гамбии",
		"в Гвинее",
		"в Гваделупе",
		"в Экваториальной Гвинее",
		"в Греции",
		"в Южной Георгии и на Южных Сандвичевых островах",
		"в Гватемале",
		"в Гуаме",
		"в Гвинее-Бисау",
		"в Гайане",
		"в Гонконге",
		"на Острове Херд и островах Макдональд",
		"в Гондурасе",
		"в Хорватии",
		"на Гаити",
		"в Венгрии",
		"в Индонезии",
		"в Ирландии",
		"в Израиле",
		"в Индии",
		"на Британской территории Индийского океана",
		"в Ираке",
		"в Иране",
		"в Исландии",
		"в Италии",
		"на Ямайке",
		"в Иордании",
		"в Японии",
		"в Кении",
		"в Кыргызстане",
		"в Камбодже",
		"в Кирибати",
		"на Коморских островах",
		"в Сент-Китсе и Невисе",
		"в Корее",
		"в Корее",
		"в Кувейте",
		"на Каймановых островах",
		"в Казахстане",
		"в Лаосской Народно-Демократической Республике",
		"в Ливане",
		"в Сент-Люсии",
		"в Лихтенштейне",
		"на Шри-Ланке",
		"в Либерии",
		"в Лесото",
		"в Литве",
		"в Люксембурге",
		"в Латвии",
		"в Ливии",
		"в Марокко",
		"в Монако",
		"в Молдове",
		"на Мадагаскаре",
		"на Маршаллових Островах",
		"в Македонии",
		"в Мали",
		"в Мьянме",
		"в Монголии",
		"в Макао",
		"на Северных Марианских островах",
		"в Мартинике",
		"в Мавритании",
		"в Монтсеррате",
		"на Мальте",
		"в Маврикии",
		"на Мальдивах",
		"в Малави",
		"в Мексике",
		"в Малайзии",
		"в Мозамбик",
		"в Намибии",
		"в Новой Каледонии",
		"в Нигере",
		"на Острове Норфолке",
		"в Нигерии",
		"в Никарагуа",
		"в Нидерландах",
		"в Норвегии",
		"в Непале",
		"в Науре",
		"в Ниуэ",
		"в Новой Зеландии",
		"в Омане",
		"в Панаме",
		"в Перу",
		"в Французской Полинезии",
		"в Папуа-Новой Гвинее",
		"в Филиппинах",
		"в Пакистане",
		"в Польше",
		"в Сен-Пьере и Микелоне",
		"на Островах Питкэрн",
		"в Пуэрто-Рико",
		"на Палестинской территории",
		"в Португалии",
		"в Палау",
		"в Парагвае",
		"в Катаре",
		"в Реюньоне",
		"в Румынии",
		"в России",
		"в Руанде",
		"в Саудовской Аравии",
		"на Соломоновых Островах",
		"на Сейшелах",
		"в Судане",
		"в Швеции",
		"в Сингапуре",
		"на Острове Святой Елены",
		"в Словении",
		"в Шпицбергене и на Ян-Майене",
		"в Словакии",
		"в Сьерра-Леоне",
		"в Сан-Марино",
		"в Сенегале",
		"в Сомали",
		"в Суринаме",
		"в Сан-Томе и Принсипи",
		"в Сальвадоре",
		"в Сирийской Арабской Республике",
		"в Свазиленде",
		"на островах Тёркс и Кайкос",
		"в Чаде",
		"на Французских Южных Территориях",
		"в Того",
		"в Таиланде",
		"в Таджикистане",
		"в Токелау",
		"в Туркменистане",
		"в Тунисе",
		"в Тонга",
		"в Тимор-Лешти",
		"В Турции",
		"в Тринидаде и Тобаго",
		"в Тувалу",
		"в Тайване",
		"в Танзании",
		"в Украине",
		"в Уганде",
		"в Соединенных Штатах Америки",
		"в Соединенных Штатах",
		"в Уругвае",
		"в Узбекистане",
		"в Ватикане",
		"в Сент-Винсенте и Гренадинах",
		"в Венесуэле",
		"на Британских Виргинских островах",
		"на Виргинских островах (США)",
		"в Вьетнаме",
		"в Вануату",
		"в Уоллисе и Футуне",
		"в Самоа",
		"в Йемене",
		"в Майотте",
		"в Сербии",
		"в Южной Африке",
		"в Замбии",
		"в Черногории",
		"в Зимбабве",
		"во всех странах",
		"во всех странах",
		"во всех странах",
		"на Аландских островах",
		"в Гернси",
		"на Острове Мэн",
		"в Джерси",
		"в Сен-Бартельми",
		"в Сен-Мартене",
		"в Бонайре, Синт-Эстатиусе и Сабе",
		"в Южном Судане",
		"во всех странах"
	);

	public $GEOIP_CONTINENT_CODES = array(
		"--",
		"AS",
		"EU",
		"EU",
		"AS",
		"AS",
		"NA",
		"NA",
		"EU",
		"AS",
		"NA",
		"AF",
		"AN",
		"SA",
		"OC",
		"EU",
		"OC",
		"NA",
		"AS",
		"EU",
		"NA",
		"AS",
		"EU",
		"AF",
		"EU",
		"AS",
		"AF",
		"AF",
		"NA",
		"AS",
		"SA",
		"SA",
		"NA",
		"AS",
		"AN",
		"AF",
		"EU",
		"NA",
		"NA",
		"AS",
		"AF",
		"AF",
		"AF",
		"EU",
		"AF",
		"OC",
		"SA",
		"AF",
		"AS",
		"SA",
		"NA",
		"NA",
		"AF",
		"AS",
		"AS",
		"EU",
		"EU",
		"AF",
		"EU",
		"NA",
		"NA",
		"AF",
		"SA",
		"EU",
		"AF",
		"AF",
		"AF",
		"EU",
		"AF",
		"EU",
		"OC",
		"SA",
		"OC",
		"EU",
		"EU",
		"NA",
		"AF",
		"EU",
		"NA",
		"AS",
		"SA",
		"AF",
		"EU",
		"NA",
		"AF",
		"AF",
		"NA",
		"AF",
		"EU",
		"AN",
		"NA",
		"OC",
		"AF",
		"SA",
		"AS",
		"AN",
		"NA",
		"EU",
		"NA",
		"EU",
		"AS",
		"EU",
		"AS",
		"AS",
		"AS",
		"AS",
		"AS",
		"EU",
		"EU",
		"NA",
		"AS",
		"AS",
		"AF",
		"AS",
		"AS",
		"OC",
		"AF",
		"NA",
		"AS",
		"AS",
		"AS",
		"NA",
		"AS",
		"AS",
		"AS",
		"NA",
		"EU",
		"AS",
		"AF",
		"AF",
		"EU",
		"EU",
		"EU",
		"AF",
		"AF",
		"EU",
		"EU",
		"AF",
		"OC",
		"EU",
		"AF",
		"AS",
		"AS",
		"AS",
		"OC",
		"NA",
		"AF",
		"NA",
		"EU",
		"AF",
		"AS",
		"AF",
		"NA",
		"AS",
		"AF",
		"AF",
		"OC",
		"AF",
		"OC",
		"AF",
		"NA",
		"EU",
		"EU",
		"AS",
		"OC",
		"OC",
		"OC",
		"AS",
		"NA",
		"SA",
		"OC",
		"OC",
		"AS",
		"AS",
		"EU",
		"NA",
		"OC",
		"NA",
		"AS",
		"EU",
		"OC",
		"SA",
		"AS",
		"AF",
		"EU",
		"EU",
		"AF",
		"AS",
		"OC",
		"AF",
		"AF",
		"EU",
		"AS",
		"AF",
		"EU",
		"EU",
		"EU",
		"AF",
		"EU",
		"AF",
		"AF",
		"SA",
		"AF",
		"NA",
		"AS",
		"AF",
		"NA",
		"AF",
		"AN",
		"AF",
		"AS",
		"AS",
		"OC",
		"AS",
		"AF",
		"OC",
		"AS",
		"EU",
		"NA",
		"OC",
		"AS",
		"AF",
		"EU",
		"AF",
		"OC",
		"NA",
		"SA",
		"AS",
		"EU",
		"NA",
		"SA",
		"NA",
		"NA",
		"AS",
		"OC",
		"OC",
		"OC",
		"AS",
		"AF",
		"EU",
		"AF",
		"AF",
		"EU",
		"AF",
		"--",
		"--",
		"--",
		"EU",
		"EU",
		"EU",
		"EU",
		"NA",
		"NA",
		"NA",
		"AF",
		"--"
	);
}