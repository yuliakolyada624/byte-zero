<?php

if(! function_exists('popularCurrencies')){
	function popularCurrencies()
	{
        $currenciesModel = new \App\Modules\Currencies\Models\CurrenciesModel();
        $rows = $currenciesModel->where('is_popular', '1')->where('is_active', 'yes')->findAll();

        ?>
        <div class="modal-currency__list">
        <?php
        
        $currency = get_currency();

        foreach($rows as $row){
            ?>
				<div class="modal-currency__card-wrapper">
                    <button class="modal-currency__card <?=($currency==$row->code ? 'active' : '')?>" type="button" data-currency="<?= $row->code ?>" aria-label="Currency option">
                        <span class="modal-currency__card-info">
                            <span class="modal-currency__card-name"><?= $row->name ?></span>
                            <span class="modal-currency__card-subname"><?= $row->code ?></span>
                        </span>
                        <span class="modal-currency__card-trigger">
                            <svg class="icon icon-done ">
                                <use href="/assets/themes/default/assets/icon/icons/icons.svg#done"></use>
                            </svg>
                        </span>
                    </button>
                </div>
            <?php
        }
        ?>
        </div>
        <?php
	}
}


if(! function_exists('allCurrencies')){
	function allCurrencies()
	{
        $currenciesModel = new \App\Modules\Currencies\Models\CurrenciesModel();
        $rows = $currenciesModel->where('is_popular', '1')->orWhere('is_popular', null)->where('is_active', 'yes')->findAll();
        ?>
        <div class="modal-currency__list">
        <?php
        $currency = get_currency();
        foreach($rows as $row){
            ?>
            <div class="modal-currency__card-wrapper">
                <button class="modal-currency__card <?=($currency==$row->code ? 'active' : '')?>" type="button" data-currency="<?= $row->code ?>" aria-label="Currency option">
                    <span class="modal-currency__card-info">
                        <span class="modal-currency__card-name"><?= $row->name ?></span>
                        <span class="modal-currency__card-subname"><?= $row->code ?></span>
                    </span>
                    <span class="modal-currency__card-trigger">
                        <svg class="icon icon-done "><use href="/assets/themes/default/assets/icon/icons/icons.svg#done"></use></svg>
                    </span>
                </button>
            </div>
            <?php
        }
        ?>
        </div>
        <?php
	}
}



/* 
if(! function_exists('lastFromBlog')){
	function lastFromBlog($limit=3)
	{
        $blogModel = new \App\Modules\Blog\Models\BlogModel();
        $rows = $blogModel->where('is_active', '1')->orderBy('created_at', 'desc')->findAll($limit);
        ?>
        <h2 class="head-2">From Our Blog</h2>
        <div class="last-blog mb-3 mt-3"><?php
        foreach($rows as $blog){
            ?>
                <div class="blog-item">
                    <?php
                    if (isset($blog->img) && $blog->img != '') {
                        ?>
                            <div class="blog-img mb-3">
                                <a href="<?=url_to_lang('blog_url', $blog->url)?>"><img src="/assets/images/uploads/blog/<?= $blog->img ?>" width="356" /></a>
                            </div>
                            <?php
                    }
                    ?>
                    <div class="mb-3">
                        <?php 
                        $time = \CodeIgniter\I18n\Time::parse($blog->updated_at);
                        echo $time->toLocalizedString('d MMM Y');
                         ?>
                    </div>
                    <div class="mb-3"> 
                        <a href="<?=url_to_lang('blog_url', $blog->url)?>" class="blog-title">
                            <?= $blog->title ?>
                        </a>
                    </div>
                    <div>
                        <p><?= substr($blog->content, 0, 200) ?> ... </p>
                    </div>
                    <span><a href="<?=url_to_lang('blog_url', $blog->url)?>">Read More <i class=readmoreico></i></a></span>
                </div>
            <?php
        }
        ?></div><?php
	}
} */


if(! function_exists('lastFromBlog')){
	function lastFromBlog($limit=3)
	{
        $ArticlesModel = new \App\Modules\Articles\Models\ArticlesModel();
        $rows = $ArticlesModel->where('is_active', '1')->orderBy('created_at', 'desc')->findAll($limit);
        ?>
        <h2 class="head-2">From Our Blog</h2>
        <div class="last-blog mb-3 mt-3"><?php
        foreach($rows as $article){
            ?>
                <div class="blog-item">
                    <?php
                    if (isset($article->img) && $article->img != '') {
                        ?>
                            <div class="blog-img mb-3">
                                <a href="<?=url_to_lang('article_url', $article->url)?>"><img src="/assets/images/uploads/articles/<?= $article->img ?>" width="356" /></a>
                            </div>
                            <?php
                    }
                    ?>
                    <div class="mb-3">
                        <?php 
                        $time = \CodeIgniter\I18n\Time::parse($article->updated_at);
                        echo $time->toLocalizedString('d MMM Y');
                         ?>
                    </div>
                    <div class="mb-3"> 
                        <a href="<?=url_to_lang('article_url', $article->url)?>" class="blog-title">
                            <?= $article->title ?>
                        </a>
                    </div>
                    <div>
                        <p><?= substr($article->content, 0, 200) ?> ... </p>
                    </div>
                    <span><a href="<?=url_to_lang('article_url', $article->url)?>">Read More <i class=readmoreico></i></a></span>
                </div>
            <?php
        }
        ?></div><?php
	}
}




if(! function_exists('popularDestinations')){
	function popularDestinations($limit=15)
	{
        $popularDestinationsModel = new \App\Modules\Widgets\Models\PopularDestinationsModel();
        $rows = $popularDestinationsModel->where('is_active', '1')->orderBy('position', 'asc')->findAll($limit);

        $lang = get_language();
        $title ='title_'.$lang;
        ?>
        <h2 class="head-2">Popular Destination</h2>
        <div class="last-pop-dest mb-3 mt-3" id="popularDestinations">
        <?php
        foreach($rows as $pd){
            ?>
                <div class="pop-dest-item">
                    <?php
                    if (isset($pd->img) && $pd->img != '') {
                        ?>
                            <div class="pop-dest-img mb-3">
                                <a href="<?=$pd->url?>"><img src="/assets/images/uploads/popular_destinations/<?= $pd->img ?>" width="100" /></a>
                            </div>
                            <?php
                    }
                    ?>
                    <div class="mb-1" class="pop-dest-title"> 
                        <a href="<?=$pd->url?>" class="pop-dest-title">
                            <?= ($pd->$title !='' ? $pd->$title : $pd->title_en) ?>
                        </a>
                    </div>
                    <div class="mb-3 pop-dest-stays"> 
                            <?=number_format($pd->stays, 0, '.', ',') ?> Stays
                    </div>
                </div>
            <?php
        }
        ?></div><?php
	}
}






if(! function_exists('destinationCitiesBucketList')){
	function destinationCitiesBucketList()
	{
        $destinationCitiesModel = new \App\Modules\Widgets\Models\DestinationCitiesModel();
        $continents = [
            'Asia',
            'Africa',
            'North America',
            'South America',
            'Europe',
            'Oceania'
        ];
        $rows = [];
        $count = 0;
        foreach($continents as $continent){
            $row = $destinationCitiesModel->where('continent', $continent)->where('is_active', '1')->orderBy('ordering', 'asc')->findAll();
            array_push($rows, $row);
            $count += sizeof($row);
        }
        

        $lang = get_language();
        $title ='title_'.$lang;
        //d($count );
        $columns = 5;
        $content_rorws= ceil($count / $columns);
        //d($content_rorws);
        $h = ($content_rorws+1) *20; // 18px
       // d($h);
        ?>
        <h2 class="head-2">Destination Cities Bucket List</h2>
        
        <div class="destination-cities mb-3 mt-3" id="destinationCities" style="display: flex;
                    flex-direction: column; flex-wrap: wrap; max-height: <?=$h?>px;">
        <?php
        //d($rows);

        $continent = '';
        foreach($rows as $row){
            foreach($row as $dc){
                if($continent!=$dc->continent){
                    $continent = $dc->continent;
                    echo "<span>".$dc->continent."</span>";
                }
                ?>
                    <div class="destination-item mb-1">
                        <a href="<?=$dc->url?>" class="destination-title">
                            <?= ($dc->$title !='' ? $dc->$title : $dc->title_en) ?>
                        </a>
                    </div>
                <?php
            }
        }
        ?></div><?php
	}
}

?>
