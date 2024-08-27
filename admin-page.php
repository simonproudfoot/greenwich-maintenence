<?php
// Add admin menu
function greenwich_wp_add_admin_menu()
{
    add_menu_page(
        'greenwich_wp Settings',
        'GD Maintenance',
        'manage_options',
        'greenwich_wp',
        'greenwich_wp_options_page',
        'dashicons-database'
    );
}
add_action('admin_menu', 'greenwich_wp_add_admin_menu');

// Register settings
function greenwich_wp_register_settings()
{
    register_setting('greenwich_wp_options', 'greenwich_wp_key');
    register_setting('greenwich_wp_options', 'greenwich_wp_database_id');
    register_setting('greenwich_wp_options', 'greenwich_wp_api_version');
}
add_action('admin_init', 'greenwich_wp_register_settings');
// Create options page
function greenwich_wp_options_page()
{
?>
    <div class="wrap greenwich_wp-admin">
        <div class="greenwich_wp-container">
            <svg class="c-header__logo-desktop" width="146px" height="115px" viewBox="0 0 146 115" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <polygon id="path-1" points="0 0.404576 36.4282336 0.404576 36.4282336 36.6778976 0 36.6778976"></polygon>
                    <polygon id="path-3" points="0.1730352 0.404576 16.5922032 0.404576 16.5922032 18.4530272 0.1730352 18.4530272"></polygon>
                    <polygon id="path-5" points="0 0.1651392 18.1372624 0.1651392 18.1372624 24.0193312 0 24.0193312"></polygon>
                    <polygon id="path-7" points="0 114.651424 145.19992 114.651424 145.19992 0.752 0 0.752"></polygon>
                </defs>
                <g id="Greenwich-Website-Desktop-/-Mobile" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Home-/-Light" transform="translate(-144.000000, -55.000000)">
                        <g id="Group-32" transform="translate(144.000000, 55.000000)">
                            <g class="big-g">
                                <path d="M9.8927856,36.9482416 L0.0002256,36.9482416 C0.0002256,47.0077456 8.1203216,55.1624336 18.1369616,55.1624336 L18.1369616,45.2270096 C13.5836016,45.2270096 9.8927856,41.5211536 9.8927856,36.9482416" id="Fill-1" fill="#000"></path>
                                <g id="Group-5" transform="translate(0.000000, 0.347424)">

                                    <g id="Clip-4"></g>
                                    <path d="M18.2140416,10.2969856 C13.6411296,10.2969856 9.9352736,13.9878016 9.9352736,18.5411616 C9.9352736,23.0945216 13.6411296,26.7853376 18.2140416,26.7853376 C22.7862016,26.7853376 26.4928096,23.0945216 26.4928096,18.5411616 C26.4928096,13.9878016 22.7862016,10.2969856 18.2140416,10.2969856 M36.4282336,18.5411616 C36.4282336,28.5578016 28.2727936,36.6778976 18.2140416,36.6778976 C8.1545376,36.6778976 -0.0001504,28.5578016 -0.0001504,18.5411616 C-0.0001504,8.5245216 8.1545376,0.4044256 18.2140416,0.4044256 C28.2727936,0.4044256 36.4282336,8.5245216 36.4282336,18.5411616" id="Fill-3" fill="#000" mask="url(#mask-2)"></path>
                                </g>
                                <g id="Group-8" transform="translate(26.320000, 0.347424)">
                                    <mask id="mask-4" fill="white">
                                        <use xlink:href="#path-3"></use>
                                    </mask>
                                    <g id="Clip-7"></g>
                                    <path d="M16.5922032,0.4042752 C7.3756912,1.3021632 0.1730352,9.0394912 0.1730352,18.4530272 L10.1077072,18.4530272 C10.1077072,14.5148032 12.8833392,11.2225472 16.5922032,10.4058752 L16.5922032,0.4042752 Z" id="Fill-6" fill="#000" mask="url(#mask-4)"></path>
                                </g>
                            </g>
                            <g class="tagline">
                                <g id="Group-11" transform="translate(0.000000, 64.267424)">
                                    <mask id="mask-6" fill="white">
                                        <use xlink:href="#path-5"></use>
                                    </mask>
                                    <g id="Clip-10"></g>
                                    <path d="M5.0095984,8.8011072 C5.0095984,11.3864832 6.9407344,12.9724512 9.0230224,12.9724512 C10.2600624,12.9724512 11.2263824,12.5611072 11.9498064,11.8564832 C12.6446544,11.1511072 13.0665264,10.1825312 13.1274384,9.0364832 C13.1274384,7.8317792 12.7649744,6.7451392 12.0716304,5.9811072 C11.4076144,5.1877472 10.3811344,4.7177472 9.0523504,4.7177472 C6.9106544,4.7177472 5.0095984,6.3924512 5.0095984,8.7710272 L5.0095984,8.8011072 Z M18.1372624,15.0291712 C18.1372624,17.4664032 17.9560304,18.7906752 17.1408624,20.1713472 C15.8429104,22.2273152 12.7950544,24.0193312 8.6605584,24.0193312 C2.8363184,24.0193312 0.6337104,20.8443872 0.3013264,18.5237152 L6.0962384,18.5237152 C6.4571984,19.3170752 7.1212144,19.4960512 7.6949904,19.7013472 C8.2988464,19.9073952 8.8726224,19.9073952 9.0230224,19.9073952 C10.9248304,19.9073952 13.0966064,18.7613472 13.0966064,15.9413472 L13.0966064,15.2043872 C12.5235824,16.1443872 11.0752304,17.5258112 8.4492464,17.5258112 C3.8921264,17.5258112 -0.0002256,14.1764032 -0.0002256,8.9477472 C-0.0002256,3.3671552 4.1034384,0.1651392 8.4492464,0.1651392 C10.3202224,0.1651392 12.1611184,0.8111072 13.1274384,2.2211072 L13.1274384,0.6937952 L18.1372624,0.6937952 L18.1372624,15.0291712 Z" id="Fill-9" fill="#000" mask="url(#mask-6)"></path>
                                </g>
                                <path d="M19.4308528,64.9613696 L24.1714608,64.9613696 L24.1714608,66.7827136 C24.6572528,65.9013696 25.5385968,64.4033856 28.4556048,64.4033856 L28.4556048,69.3086816 L28.2728688,69.3086816 C25.6897488,69.3086816 24.4752688,70.2193536 24.4752688,72.5106976 L24.4752688,81.2639776 L19.4308528,81.2639776 L19.4308528,64.9613696 Z" id="Fill-12" fill="#000"></path>
                                <path d="M40.2019952,71.1007728 C40.0809232,70.3367408 39.0521872,68.5153968 36.4487632,68.5153968 C33.8453392,68.5153968 32.8158512,70.3367408 32.6947792,71.1007728 L40.2019952,71.1007728 Z M32.6338672,74.8013648 C32.8459312,76.5347248 34.5409392,77.6807728 36.5089232,77.6807728 C38.1136912,77.6807728 38.9611952,77.0047248 39.5665552,76.1534608 L44.7132432,76.1534608 C43.8965712,77.9740528 42.7151792,79.3840528 41.2923952,80.3240528 C39.8996912,81.2941328 38.2347632,81.7934608 36.5089232,81.7934608 C31.6953712,81.7934608 27.6082512,78.0041328 27.6082512,73.1567408 C27.6082512,68.6041328 31.3028272,64.4034608 36.4186832,64.4034608 C38.9920272,64.4034608 41.2014032,65.3727888 42.7753392,66.9880848 C44.8944752,69.1914448 45.5299152,71.8053968 45.1373712,74.8013648 L32.6338672,74.8013648 Z" id="Fill-14" fill="#000"></path>
                                <path d="M58.3715184,71.1007728 C58.2504464,70.3367408 57.2209584,68.5153968 54.6182864,68.5153968 C52.0148624,68.5153968 50.9853744,70.3367408 50.8643024,71.1007728 L58.3715184,71.1007728 Z M50.8033904,74.8013648 C51.0154544,76.5347248 52.7104624,77.6807728 54.6784464,77.6807728 C56.2832144,77.6807728 57.1307184,77.0047248 57.7360784,76.1534608 L62.8827664,76.1534608 C62.0645904,77.9740528 60.8847024,79.3840528 59.4619184,80.3240528 C58.0692144,81.2941328 56.4042864,81.7934608 54.6784464,81.7934608 C49.8648944,81.7934608 45.7777744,78.0041328 45.7777744,73.1567408 C45.7777744,68.6041328 49.4708464,64.4034608 54.5882064,64.4034608 C57.1607984,64.4034608 59.3709264,65.3727888 60.9448624,66.9880848 C63.0639984,69.1914448 63.6994384,71.8053968 63.3061424,74.8013648 L50.8033904,74.8013648 Z" id="Fill-16" fill="#000"></path>
                                <path d="M64.1249952,64.9613696 L68.8174752,64.9613696 L68.8174752,66.6947296 C69.3920032,65.9013696 70.4523232,64.4033856 73.4490432,64.4033856 C79.1100992,64.4033856 79.6846272,68.8680096 79.6846272,71.0713696 L79.6846272,81.2639776 L74.6605152,81.2639776 L74.6605152,72.3640576 C74.6605152,70.5712896 74.2664672,68.9853216 72.0262592,68.9853216 C69.5439072,68.9853216 69.1506112,70.7186816 69.1506112,72.3933856 L69.1506112,81.2639776 L64.1249952,81.2639776 L64.1249952,64.9613696 Z" id="Fill-18" fill="#000"></path>
                                <polygon id="Fill-20" fill="#000" points="79.4113504 64.9613696 84.6174464 64.9613696 87.1907904 75.0953216 89.9461184 64.9613696 94.1843904 64.9613696 97.0307104 75.0953216 99.5431424 64.9613696 104.71991 64.9613696 99.5739744 81.2639776 94.9115744 81.2639776 92.0351744 70.7186816 89.2196864 81.2639776 84.5580384 81.2639776"></polygon>
                                <mask id="mask-8" fill="white">
                                    <use xlink:href="#path-7"></use>
                                </mask>
                                <g id="Clip-23"></g>
                                <path d="M105.328128,81.264128 L110.353744,81.264128 L110.353744,64.96152 L105.328128,64.96152 L105.328128,81.264128 Z M105.328128,63.22816 L110.353744,63.22816 L110.353744,59.993056 L105.328128,59.993056 L105.328128,63.22816 Z" id="Fill-22" fill="#000" mask="url(#mask-8)"></path>
                                <path d="M128.850914,75.0667456 C127.942498,78.7673376 124.58181,81.7933856 120.041234,81.7933856 C114.955458,81.7933856 111.050322,77.9153216 111.050322,73.0686816 C111.050322,68.2806976 114.894546,64.4033856 119.920162,64.4033856 C124.369746,64.4033856 127.972578,67.2527136 128.820834,71.2473376 L123.734306,71.2473376 C123.19061,70.1313696 122.191202,68.9567456 120.102146,68.9567456 C118.920754,68.8973376 117.922098,69.3380096 117.195666,70.1012896 C116.499314,70.8653216 116.106018,71.9233856 116.106018,73.0980096 C116.106018,75.4773376 117.710786,77.2400256 120.102146,77.2400256 C122.191202,77.2400256 123.19061,76.0646496 123.734306,75.0667456 L128.850914,75.0667456 Z" id="Fill-24" fill="#000" mask="url(#mask-8)"></path>
                                <path d="M129.639611,59.9929808 L134.665979,59.9929808 L134.665979,64.4034608 L134.665979,66.4594288 C135.573643,64.9907728 137.269403,64.4034608 139.054651,64.4034608 C141.627243,64.4034608 143.141771,65.2848048 144.050187,66.7241328 C144.957851,68.1341328 145.199995,70.0720368 145.199995,72.1580848 L145.199995,81.2640528 L140.175131,81.2640528 L140.175131,72.3934608 C140.175131,71.4820368 140.054059,70.6307728 139.660011,70.0141328 C139.236635,69.3967408 138.570363,68.9853968 137.480715,68.9853968 C136.088011,68.9853968 135.360827,69.6020368 135.027691,70.3074128 C134.665979,71.0120368 134.665979,71.8053968 134.665979,72.2167408 L134.665979,81.2640528 L129.639611,81.2640528 L129.639611,59.9929808 Z" id="Fill-25" fill="#000" mask="url(#mask-8)"></path>
                                <path d="M4.985008,99.4325984 C4.985008,101.929238 6.816128,103.604694 9.157856,103.604694 C10.359552,103.604694 11.471008,103.134694 12.251584,102.370662 C13.03216,101.60663 13.482608,100.549318 13.4232,99.3446144 C13.4232,98.1692384 12.942672,97.1713344 12.191424,96.4659584 C11.440176,95.7320064 10.389632,95.3206624 9.218768,95.3206624 C6.3356,95.3206624 4.985008,97.5232704 4.985008,99.4032704 L4.985008,99.4325984 Z M18.136736,107.628646 L13.392368,107.628646 L13.392368,105.865958 C12.912592,106.542006 11.711648,108.158054 8.3472,108.158054 C3.302784,108.158054 0,104.338646 0,99.4325984 C0,93.9106624 4.023952,90.7680544 8.257712,90.7680544 C11.20104,90.7680544 12.611792,92.1780544 13.151728,92.7059584 L13.151728,90.9432704 L13.151728,86.3568224 L18.136736,86.3568224 L18.136736,107.628646 Z" id="Fill-26" fill="#000" mask="url(#mask-8)"></path>
                                <path d="M31.4852624,97.46484 C31.3641904,96.70156 30.3347024,94.879464 27.7320304,94.879464 C25.1286064,94.879464 24.0991184,96.70156 23.9780464,97.46484 L31.4852624,97.46484 Z M23.9171344,101.165432 C24.1291984,102.899544 25.8242064,104.04484 27.7921904,104.04484 C29.3969584,104.04484 30.2444624,103.369544 30.8498224,102.517528 L35.9965104,102.517528 C35.1790864,104.338872 33.9984464,105.748872 32.5756624,106.688872 C31.1829584,107.6582 29.5180304,108.157528 27.7921904,108.157528 C22.9786384,108.157528 18.8915184,104.3682 18.8915184,99.52156 C18.8915184,94.9682 22.5853424,90.767528 27.7019504,90.767528 C30.2752944,90.767528 32.4846704,91.736856 34.0586064,93.352152 C36.1777424,95.555512 36.8131824,98.169464 36.4206384,101.165432 L23.9171344,101.165432 Z" id="Fill-27" fill="#000" mask="url(#mask-8)"></path>
                                <path d="M44.9897536,95.9082752 C44.9589216,95.5555872 44.8980096,94.6742432 43.4150656,94.6742432 C42.3554976,94.6742432 41.9922816,95.3209632 41.9922816,95.7616352 C41.9922816,96.4955872 43.2330816,96.9949152 44.5656256,97.3761792 C47.4104416,98.1409632 50.4387456,98.9628992 50.4387456,102.488275 C50.4387456,106.071555 47.3202016,108.186179 43.5962976,108.186179 C41.0537856,108.186179 37.2095616,106.807011 36.7546016,102.517603 L41.7501376,102.517603 C41.9614496,104.015587 43.4451456,104.279539 43.6579616,104.279539 C44.5047136,104.279539 45.4131296,103.809539 45.4131296,103.016179 C45.4131296,101.900963 44.1723296,101.753571 40.9627936,100.548867 C38.7834976,99.8735712 36.9666656,98.4928992 36.9666656,96.2895392 C36.9666656,92.9123072 39.9934656,90.7676032 43.4759776,90.7676032 C45.6853536,90.7676032 49.5002496,91.6188672 49.9243776,95.9082752 L44.9897536,95.9082752 Z" id="Fill-28" fill="#000" mask="url(#mask-8)"></path>
                                <path d="M51.439056,107.628496 L56.464672,107.628496 L56.464672,91.325136 L51.439056,91.325136 L51.439056,107.628496 Z M51.439056,89.591776 L56.464672,89.591776 L56.464672,86.356672 L51.439056,86.356672 L51.439056,89.591776 Z" id="Fill-29" fill="#000" mask="url(#mask-8)"></path>
                                <path d="M62.2170208,99.4325984 C62.2170208,102.017974 64.1541728,103.604694 66.2432288,103.604694 C67.4840288,103.604694 68.4526048,103.192598 69.1790368,102.487974 C69.8753888,101.782598 70.2995168,100.814022 70.3596768,99.6679744 C70.3596768,98.4632704 69.9964608,97.3766304 69.3008608,96.6125984 C68.6345888,95.8192384 67.6051008,95.3492384 66.2725568,95.3492384 C64.1240928,95.3492384 62.2170208,97.0246944 62.2170208,99.4032704 L62.2170208,99.4325984 Z M75.3852928,105.660662 C75.3852928,108.098646 75.2040608,109.422918 74.3866368,110.802838 C73.0841728,112.858806 70.0265408,114.651574 65.8800128,114.651574 C60.0369728,114.651574 57.8268448,111.47663 57.4937088,109.155958 L63.3066688,109.155958 C63.6691328,109.948566 64.3354048,110.128294 64.9106848,110.332838 C65.5160448,110.538886 66.0920768,110.538886 66.2432288,110.538886 C68.1503008,110.538886 70.3295968,109.392838 70.3295968,106.572838 L70.3295968,105.83663 C69.7543168,106.77663 68.3014528,108.158054 65.6671968,108.158054 C61.0957888,108.158054 57.1914048,104.808646 57.1914048,99.5792384 C57.1914048,93.9986464 61.3078528,90.7966304 65.6671968,90.7966304 C67.5441888,90.7966304 69.3911008,91.4425984 70.3596768,92.8525984 L70.3596768,91.3252864 L75.3852928,91.3252864 L75.3852928,105.660662 Z" id="Fill-30" fill="#000" mask="url(#mask-8)"></path>
                                <path d="M76.6794848,91.3254368 L81.3719648,91.3254368 L81.3719648,93.0587968 C81.9464928,92.2654368 83.0068128,90.7674528 86.0035328,90.7674528 C91.6645888,90.7674528 92.2391168,95.2320768 92.2391168,97.4354368 L92.2391168,107.628797 L87.2142528,107.628797 L87.2142528,98.7281248 C87.2142528,96.9361088 86.8209568,95.3493888 84.5807488,95.3493888 C82.0983968,95.3493888 81.7051008,97.0827488 81.7051008,98.7574528 L81.7051008,107.628797 L76.6794848,107.628797 L76.6794848,91.3254368 Z" id="Fill-31" fill="#000" mask="url(#mask-8)"></path>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>

            <div class="notice notice-info">
                <p><?php _e('<b>Please do not change any of these settings.</b> This plugin connects your WordPress site with our systems to ensure we keep your site up to date.', 'greenwich_wp'); ?></p>
            </div>
            <?php
            // Display any existing admin notices
            settings_errors('greenwich_wp_messages');

            // Get the current user's email
            $current_user = wp_get_current_user();
            $user_email = $current_user->user_email;
            // Check if the email domain is greenwich-design.co.uk
            $allowed_domain = 'greenwich-design.co.uk';
            $email_parts = explode('@', $user_email);
            $user_domain = end($email_parts);

            if ($user_domain === $allowed_domain) {
            ?>
                <form id="greenwich_wp-connect-form" method="post" action="">
                    <?php
                    settings_fields('greenwich_wp_options');
                    do_settings_sections('greenwich_wp_options');
                    wp_nonce_field('greenwich_wp_connect', 'greenwich_wp_connect_nonce');
                    ?>


                    <div class="form-group">
                        <label for="greenwich_wp_key"><?php _e('API Key', 'greenwich_wp'); ?></label>
                        <input type="text" id="greenwich_wp_key" name="greenwich_wp_key" value="<?php echo esc_attr(get_option('greenwich_wp_key')); ?>" class="regular-text" />
                    </div>
                    <div class="form-group">
                        <label for="greenwich_wp_database_id"><?php _e('Database ID', 'greenwich_wp'); ?></label>
                        <input type="text" id="greenwich_wp_database_id" name="greenwich_wp_database_id" value="<?php echo esc_attr(get_option('greenwich_wp_database_id')); ?>" class="regular-text" />
                    </div>
                    <div class="form-group">
                        <label for="greenwich_wp_api_version"><?php _e('API Version', 'greenwich_wp'); ?></label>
                        <input type="text" id="greenwich_wp_api_version" name="greenwich_wp_api_version" value="<?php echo esc_attr(get_option('greenwich_wp_api_version', '2022-06-28')); ?>" class="regular-text" />
                    </div>
                    <div class="submit-button-container">
                        <?php submit_button(__('Connect and Sync', 'greenwich_wp'), 'primary', 'greenwich_wp_connect', false); ?>
                        <span class="spinner" style="float: none; visibility: hidden;"></span>
                    </div>
                </form>
                <div id="greenwich_wp-message" class="notice" style="display: none; margin-top: 20px;"></div>

            <?php } ?>
        </div>
    </div>

    <style>
        .submit-button-container {
            display: flex;
            align-items: center;
        }

        .submit-button-container .spinner {
            margin-left: 10px;
        }
    </style>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#greenwich_wp-connect-form').on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                var $submitButton = $form.find(':submit');
                var $spinner = $form.find('.spinner');
                var $message = $('#greenwich_wp-message');

                $submitButton.prop('disabled', true);
                $spinner.css('visibility', 'visible');
                $message.hide().removeClass('notice-success notice-error');

                var data = $form.serialize() + '&action=greenwich_wp_connect_and_sync';

                $.post(ajaxurl, data, function(response) {
                        console.log('AJAX Response:', response);

                        if (response.success) {
                            $message.addClass('notice-success').html('<p>' + response.data.message + '</p>').show();
                        } else {
                            $message.addClass('notice-error').html('<p>' + response.data.message + '</p>').show();
                            if (response.data.debug) {
                                console.error('Debug information:', response.data.debug);
                            }
                        }
                    })
                    .fail(function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        console.log('XHR:', xhr.responseText);
                        $message.addClass('notice-error').html('<p>An error occurred while processing your request. Please check the console for more details.</p>').show();
                    })
                    .always(function() {
                        $submitButton.prop('disabled', false);
                        $spinner.css('visibility', 'hidden');
                    });
            });
        });
    </script>
<?php
}
// AJAX handler for connect and sync
function greenwich_wp_ajax_connect_and_sync()
{
    check_ajax_referer('greenwich_wp_connect', 'greenwich_wp_connect_nonce');

    $api_key = sanitize_text_field($_POST['greenwich_wp_key']);
    $database_id = sanitize_text_field($_POST['greenwich_wp_database_id']);
    $api_version = sanitize_text_field($_POST['greenwich_wp_api_version']);

    // Save the options
    update_option('greenwich_wp_key', $api_key);
    update_option('greenwich_wp_database_id', $database_id);
    update_option('greenwich_wp_api_version', $api_version);

    // Perform connection test and sync
    $connection_result = greenwich_wp_test_connection();
    if ($connection_result['success']) {
        $sync_result = greenwich_wp_sync_site_data();
        if ($sync_result['success']) {
            wp_send_json_success(array('message' => 'Connected and synced successfully.'));
        } else {
            wp_send_json_error(array('message' => 'Connection successful, but sync failed: ' . $sync_result['message'], 'debug' => $sync_result['debug']));
        }
    } else {
        wp_send_json_error(array('message' => 'Connection failed: ' . $connection_result['message']));
    }
}
add_action('wp_ajax_greenwich_wp_connect_and_sync', 'greenwich_wp_ajax_connect_and_sync');

// Enqueue admin styles
function greenwich_wp_enqueue_admin_styles($hook)
{
    if ('toplevel_page_greenwich_wp' !== $hook) {
        return;
    }
    wp_enqueue_style('greenwich_wp-admin-styles', plugin_dir_url(__FILE__) . 'css/admin-styles.css', array(), '1.0.0');
}
add_action('admin_enqueue_scripts', 'greenwich_wp_enqueue_admin_styles');

// Remove other plugin notices on greenwich_wp pages
function greenwich_wp_remove_notices()
{
    if (isset($_GET['page']) && $_GET['page'] === 'greenwich_wp') {
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
    }
}
add_action('admin_init', 'greenwich_wp_remove_notices');
