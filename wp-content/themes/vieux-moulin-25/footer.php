</main>
<nav id="navbar" class="navbar">
    <h2 class="sro">Navigation principale</h2>
    <a href="#main" id="escape-link" tabindex="1" title="Lien d’évitement">Aller au contenu principal</a>

    <div class="navbar__container">
        <a href="<?= get_home_url() ?>" tabindex="1" class="navbar__logo__link" title="Retourner à l’accueil">
            <svg class="navbar__logo" xmlns="http://www.w3.org/2000/svg" width="112px" height="72px" fill="none"
                 viewBox="0 0 510 327">
                <path fill="#fff" d="M0 0h510v326H0z"/>
                <path fill="#FDD87A"
                      d="m459 286 40 11-5 18-40-11zM380 270l22 6-2 9-22-6zM418 265l32 6-3 13-31-5zM354 259l16 3-1 4-16-3zM461 246h41v19h-41zM381 251h23v9h-23zM416 236l32-3 1 14-32 3zM353 247l16-1v4l-16 1zM453 206l40-11 5 19-40 10zM377 231l22-6 2 9-22 6zM407 209l30-11 5 13-30 11zM349 235l15-6 1 4-15 6zM435 170l36-21 9 17-35 20zM368 214l20-12 4 8-20 12zM391 184l26-18 8 11-26 18zM342 225l13-9 3 3-14 9zM408 140l29-29 14 13-29 29zM355 200l16-17 7 7-16 16zM369 165l21-25 10 9-20 25zM332 217l11-12 3 2-11 13zM374 117l20-36 17 10-21 35zM338 189l11-20 8 5-11 20zM343 152l14-29 12 6-13 29zM321 211l6-14 4 1-7 15zM336 105l10-40 19 5-11 40zM319 183l6-23 9 3-6 22zM315 145l5-31 14 2-5 32zM309 209l2-16 4 1-3 15z"/>
                <path fill="#1E1B16"
                      d="M72 8h34l62 149L242 8h34L168 218 72 8ZM8 318h39l21-187 84 173h27l90-180 19 194h60L311 33h-31L168 250 71 33H50L8 318Z"/>
                <path fill="#295B96"
                      d="M293 269c-84-1-155 49-155 49s52-31 109-31c69 0 65 25 119 25 64 0 107-42 107-42s-29 26-55 26c-41 0-71-27-125-27Z"/>
                <path fill="#33A8BC"
                      d="M224 224c-84-1-155 49-155 49s51-31 108-31c70 0 66 25 120 25 64 0 107-42 107-42s-29 26-56 26c-41 0-70-27-124-27Z"/>
            </svg>
        </a>

        <?php $navLinks = vm_get_navigation_links('main');
        if ($navLinks): ?>
            <ul class="navbar__subcontainer">
                <?php foreach ($navLinks as $navLink): ?>
                    <li class="navbar__li"><a tabindex="1"
                                              class="navbar__link <?= (($url = $navLink->url) === get_page_link()) ? ' navbar__link--active' : '' ?>"
                                              href="<?= $url ?>" title="Vers la page <?= $navLink->label ?>">
                            <?= $navLink->label ?></a>
                    </li>
                <?php endforeach; ?>

                <li class="navbar__li navbar__li--checkbox">
                    <input type="checkbox" class="navbar__checkbox" id="burger-menu">
                </li>
            </ul>

            <label for="burger-menu" class="navbar__menu">Ouverture du burger menu mobile</label>

        <?php endif; ?>
    </div>
</nav>

<footer class="footer">
    <div class="footer__container">
        <?php if ($footNavLinks = vm_get_navigation_links('footer')): ?>
            <nav class="footer__item footer__item--nav">
                <h2 class="footer__item__title">Navigation<span class="sro"> de pied de page</span></h2>
                <ul class="footer__item__container">
                    <?php foreach ($footNavLinks as $footNavLink): ?>
                        <li class="footer__item__li">
                            <a href="<?= $footNavLink->url ?>" class="footer__item__link"><?= $footNavLink->label ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>

        <?php if ($socialLinks = vm_get_navigation_links('social')): ?>
            <aside class="footer__item">
                <h2 class="footer__item__title">Nos réseaux</h2>

                <ul class="footer__item__container">
                    <?php foreach ($socialLinks as $socialLink): ?>
                        <a href="<?= $socialLink->url ?>" class="footer__item__link"><?= $socialLink->label ?></a>
                    <?php endforeach; ?>
                </ul>
            </aside>
        <?php endif ?>
    </div>

    <p class="footer__copyright">© <?= get_bloginfo('name'); ?></p>
    <?php wp_footer() ?>
</footer>
</body>
</html>
