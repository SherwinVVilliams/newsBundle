@include('site.layouts.header')

<div class="header">
    <div class="container">
        <div class="row d-flex  flex-row">
            <div class="col-lg-1 col-md-4  header_reverse">
                <a href="/">
                <div class="header__logo first_variant">
                    <img src="/site/img/main/SVG_logo/LOGO_wh_bg.svg" alt="">
                </div>
<!--                    <div class="header__logo two_variant">-->
<!--                        <img src="/site/img/main/SVG_logo/LOGO_wh_bg.svg" alt="">-->
<!--                    </div>-->
                </a>
            </div>
            <div class="col-lg-11 col-md-12">
                <div class="row">
                    <div class="col justify-content-end">
                        <div class="header__login-interpreter">
                            <div class="header__interpreter laptop__button adress_laptop_main">
                                <a href="/" class="button__adress">Получить адрес</a>
                            </div>
                            <div class="header__interpreter laptop__button">
                                <a href="#js_enterSite" class="button__orange modal-trigger">Сделать заказ</a>
                            </div>
                            <div class="header__login">
                                <a class="modal-trigger" href="#js_enterSite">
                                <div class="header__man-black">
                                    <img src="/site/img/main/menu/Cabinet_in.svg" alt="">
                                </div>
                                <div class="header__man-orange">
                                    <img src="/site/img/main/menu/Cabinet_in_oranj.svg" alt="">
                                </div>
                                <div class="header__hint">
                                    <p>Вход в личный кабинет</p>
                                </div>
                                </a>
                            </div>

                        </div>

                    </div>
                    <div class="w-100"></div>
                    <div class="col align-self-center">
                        <input class="checkbox-toggle" type="checkbox"/>
                        <div class="hamburger">
                            <div>
                                <svg viewBox="0 0 800 600" class="">
                                    <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                          class="top_bar"/>

                                    <path d="M300,320 L540,320" class="middle_bar"/>

                                    <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                          class="bottom_bar"
                                          transform="translate(480, 320) scale(1, -1) translate(-480, -318)"/>
                                </svg>

                            </div>
                        </div>
                        <div class="header__menu">
                            <div>
                                <div>
                                    <ul>
                                        <li><a class="header__menu_active" href="/">Главная</a></li>
                                        <li><a class="header__menu_catalog" href="/catalogue.php">Каталог магазинов</a></li>
                                        <li><a href="/discount.php" class="header__menu_akcii">Акции</a></li>
                                        <li><a href="/group_buy.php" class="header__menu_akcii header__menu_akcii_company">Компания на скидку</a></li>
                                        <li><a class="header__menu_tarife" href="/rate.php">Тарифы</a></li>
                                        <li><a class="header__menu_quest" href="/faq.php">Вопросы</a></li>
                                        <li><a class="header__menu_news" href="/news.php">Новости</a></li>
                                        <li><a class="header__menu_rewiews" href="/reviews.php">Отзывы</a></li>
                                        <li><a class="header__menu_company" href="/about__company.php">О компании</a></li>
                                    </ul>
                                    <div class="header__interpreter laptop__button adress_button_main">
                                        <a href="/" class="button__adress">Получить адрес</a>
                                    </div>
                                    <div class="header__interpreter mob_button_header">
                                        <a href="#js_enterSite" class="button__orange modal-trigger">Сделать заказ</a>
                                    </div>
                                    <div class="header__login mob_lk_login">
                                        <a class="modal-trigger" href="#js_enterSite">
                                            <div class="header__man-black">
                                                <img src="/site/img/main/menu/Cabinet_in.svg" alt="">
                                            </div>
                                            <div class="header__man-orange">
                                                <img src="/site/img/main/menu/Cabinet_in_oranj.svg" alt="">
                                            </div>
                                            <div class="header__hint">
                                                <p>Вход в личный кабинет</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="header_revers_mob">
                <a href="/">
                <div class="header__logo">
                    <img src="/site/img/main/SVG_logo/LOGO_wh_bg.svg" alt="">
                </div>
                </a>
            </div>
        </div>
    </div>

</div>
