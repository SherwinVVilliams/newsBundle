<?php

/* -*- Mode: C; indent-tabs-mode: t; c-basic-offset: 2; tab-width: 2 -*- */
/* geoip.inc
 *
 * Copyright (C) 2007 MaxMind LLC
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

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



function geoip_load_shared_mem($file)
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

function _setup_segments($gi)
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

function geoip_open($filename, $flags)
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

    $gi = _setup_segments($gi);
    return $gi;
}

function geoip_close($gi)
{
    if ($gi->flags & GEOIP_SHARED_MEMORY) {
        return true;
    }

    return fclose($gi->filehandle);
}

function geoip_country_id_by_name_v6($gi, $name)
{
    $rec = dns_get_record($name, DNS_AAAA);
    if (!$rec) {
        return false;
    }
    $addr = $rec[0]["ipv6"];
    if (!$addr || $addr == $name) {
        return false;
    }
    return geoip_country_id_by_addr_v6($gi, $addr);
}

function geoip_country_id_by_name($gi, $name)
{
    $addr = gethostbyname($name);
    if (!$addr || $addr == $name) {
        return false;
    }
    return geoip_country_id_by_addr($gi, $addr);
}

function geoip_country_code_by_name_v6($gi, $name)
{
    $country_id = geoip_country_id_by_name_v6($gi, $name);
    if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_CODES[$country_id];
    }
    return false;
}

function geoip_country_code_by_name($gi, $name)
{
    $country_id = geoip_country_id_by_name($gi, $name);
    if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_CODES[$country_id];
    }
    return false;
}

function geoip_country_name_by_name_v6($gi, $name)
{
    $country_id = geoip_country_id_by_name_v6($gi, $name);
    if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_NAMES[$country_id];
    }
    return false;
}

function geoip_country_name_by_name($gi, $name)
{
    $country_id = geoip_country_id_by_name($gi, $name);
    if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_NAMES[$country_id];
    }
    return false;
}

function geoip_country_id_by_addr_v6($gi, $addr)
{
    $ipnum = inet_pton($addr);
    return _geoip_seek_country_v6($gi, $ipnum) - GEOIP_COUNTRY_BEGIN;
}

function geoip_country_id_by_addr($gi, $addr)
{
    $ipnum = ip2long($addr);
    return _geoip_seek_country($gi, $ipnum) - GEOIP_COUNTRY_BEGIN;
}

function geoip_country_code_by_addr_v6($gi, $addr)
{
    $country_id = geoip_country_id_by_addr_v6($gi, $addr);
    if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_CODES[$country_id];
    }
    return false;
}

function geoip_country_code_by_addr($gi, $addr)
{
    if ($gi->databaseType == GEOIP_CITY_EDITION_REV1) {
        $record = geoip_record_by_addr($gi, $addr);
        if ($record !== false) {
            return $record->country_code;
        }
    } else {
        $country_id = geoip_country_id_by_addr($gi, $addr);
        if ($country_id !== false) {
            return $gi->GEOIP_COUNTRY_CODES[$country_id];
        }
    }
    return false;
}

function geoip_country_name_by_addr_v6($gi, $addr)
{
    $country_id = geoip_country_id_by_addr_v6($gi, $addr);
    if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_NAMES[$country_id];
    }
    return false;
}

function geoip_country_name_by_addr($gi, $addr)
{
    if ($gi->databaseType == GEOIP_CITY_EDITION_REV1) {
        $record = geoip_record_by_addr($gi, $addr);
        return $record->country_name;
    } else {
        $country_id = geoip_country_id_by_addr($gi, $addr);
        if ($country_id !== false) {
            return $gi->GEOIP_COUNTRY_NAMES[$country_id];
        }
    }
    return false;
}

function _geoip_seek_country_v6($gi, $ipnum)
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

function _geoip_seek_country($gi, $ipnum)
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

function _common_get_org($gi, $seek_org)
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

function _get_org_v6($gi, $ipnum)
{
    $seek_org = _geoip_seek_country_v6($gi, $ipnum);
    if ($seek_org == $gi->databaseSegments) {
        return null;
    }
    return _common_get_org($gi, $seek_org);
}

function _get_org($gi, $ipnum)
{
    $seek_org = _geoip_seek_country($gi, $ipnum);
    if ($seek_org == $gi->databaseSegments) {
        return null;
    }
    return _common_get_org($gi, $seek_org);
}


function geoip_name_by_addr_v6($gi, $addr)
{
    if ($addr == null) {
        return 0;
    }
    $ipnum = inet_pton($addr);
    return _get_org_v6($gi, $ipnum);
}

function geoip_name_by_addr($gi, $addr)
{
    if ($addr == null) {
        return 0;
    }
    $ipnum = ip2long($addr);
    return _get_org($gi, $ipnum);
}

function geoip_org_by_addr($gi, $addr)
{
    return geoip_name_by_addr($gi, $addr);
}

function _get_region($gi, $ipnum)
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

function geoip_region_by_addr($gi, $addr)
{
    if ($addr == null) {
        return 0;
    }
    $ipnum = ip2long($addr);
    return _get_region($gi, $ipnum);
}

function _safe_substr($string, $start, $length)
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
