<?php get_header(); ?>
<main id="company_info">

    <?php
    if (have_posts()) : while (have_posts()) : the_post();
            $corporate_spirit = get_field('corporate_spirit');
            $basic_philosophy = get_field('basic_philosophy');
            $company_name = get_field('company_name');
            $location = get_field('location');
            $telephone_number = get_field('telephone_number');
            $fax_number = get_field('fax_number');
            $business_content = get_field('business_content');
        endwhile;
    endif;
    ?>

    <h1 class="main__ttl">会社概要</h1>
    <section class="spirit">
        <h2 class="spirit__ttl">企業精神</h2>
        <p class="spirit__p"><?php echo esc_html($corporate_spirit); ?></p>
    </section>
    <section class="philosophy">
        <h2 class="philosophy__ttl">基本理念</h2>
        <p class="philosophy__p"><?php echo esc_html($basic_philosophy); ?></p>
    </section>
    <section>
        <table class="info__table">
            <tbody>
                <tr>
                    <th class="info__th">会社名</th>
                    <td class="info__td"><?php echo esc_html($company_name); ?></td>
                </tr>
                <tr>
                    <th class="info__th">所在地</th>
                    <td class="info__td"><?php echo esc_html($location); ?></td>
                </tr>
                <tr>
                    <th class="info__th">電話</th>
                    <td class="info__td"><?php echo esc_html($telephone_number); ?></td>
                </tr>
                <tr>
                    <th class="info__th">FAX</th>
                    <td class="info__td"><?php echo esc_html($fax_number); ?></td>
                </tr>
                <tr>
                    <th class="info__th">事業内容</th>
                    <td class="info__td"><?php echo esc_html($business_content); ?></td>
                </tr>
            </tbody>
        </table>
    </section>
</main>
<?php get_footer(); ?>