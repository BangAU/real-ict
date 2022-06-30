<?php  
   if($post->ancestors):
?>

<section>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                <?php if(function_exists('bcn_display'))
                {
                    bcn_display();
                }?>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>