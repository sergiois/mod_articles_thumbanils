<?php
defined('_JEXEC') or die;

$spanmd = 4;
switch($params->get('count'))
{
    case 1: $spanmd = 12; break;
    case 2: $spanmd = 6; break;
    case 3: $spanmd = 4; break;
    case 4: $spanmd = 3; break;
    default: $spanmd = 4;
}
?>
<div class="row <?php echo $moduleclass_sfx; ?>">
<?php foreach ($items as $item) : ?>
    <div class="col-xs-12 col-sm-6 col-md-<?php echo $spanmd; ?> col-lg-<?php echo $spanmd; ?>" itemscope itemtype="https://schema.org/Article">
        <div class="thumbnail">
            <?php if($params->get('show_image') != 'off'): ?>
                <?php
                $images = json_decode($item->images);
                $image = $images->image_intro;
                $alt = $images->image_intro_alt ? $images->image_intro_alt : $item->title;
                if($params->get('show_image') == 'fulltext')
                {
                    $image = $images->image_fulltext;
                    $alt = $images->image_fulltext_alt ? $images->image_fulltext_alt : $item->title;
                }
                ?>
                <?php if($params->get('link_image')): ?>
                    <a href="<?php echo $item->link; ?>" itemprop="url">
                        <img data-src="<?php echo $image; ?>" src="<?php echo $image; ?>" alt="<?php echo $alt; ?>">
                    </a>
                <?php else: ?>
                    <img data-src="<?php echo $image; ?>" src="<?php echo $image; ?>" alt="<?php echo $alt; ?>">
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if($params->get('show_title') || $params->get('show_content') != 'offc' || $params->get('show_readmore')): ?>
            <div class="caption">
                <?php if($params->get('show_title')): ?>
                    <h3 itemprop="name">
                        <?php if($params->get('link_title')): ?>
                            <a href="<?php echo $item->link; ?>" itemprop="url">
                        <?php endif; ?>
                        <?php echo $item->title; ?>
                        <?php if($params->get('link_title')): ?>
                            </a>
                        <?php endif; ?>
                    </h3>
                <?php endif; ?>

                <?php if($params->get('show_content') != 'offc'): ?>
                    <?php
                    if($params->get('show_content') == 'partc'):
                        $cleanText = filter_var($item->introtext, FILTER_SANITIZE_STRING);
                        $introCleanText = strip_tags($cleanText);
                        if (strlen($introCleanText) > $params->get('tam_content', 200))
                        {
                            $introtext = substr($introCleanText,0,strrpos(substr($introCleanText,0,$params->get('tam_content', 200))," ")).'...';
                        }
                        else
                        {
                            $introtext = $introCleanText;
                        }
                    else:
                        $introtext = $item->introtext;
                    endif;
                    ?>
                    <p><?php echo $introtext; ?></p>
                <?php endif; ?>
                
                <?php if($params->get('show_readmore')): ?>
                <p class="text-right">
                    <a href="<?php echo $item->link; ?>" class="btn btn-primary"><?php echo $params->get('readmore_text') ? $params->get('readmore_text') : JText::_('MOD_ARTICLES_THUMBNAILS_FIELD_READMORE_TEXT'); ?></a>
                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
	</div>
<?php endforeach; ?>
</div>