<?php if(!defined('PLX_ROOT')) exit; ?>

	<aside class="aside col sml-12 med-3" role="complementary">

		<h3>
            <?php $plxShow->lang('CATEGORIES'); ?>
        </h3>   

        <?php
        if (class_exists('categories')) {
        $lvl1='ul';
        $lvl2='ul';
        $lvl3='ul';
        $title='span';
        $kid='li';
        $mark= 'mark';
		$menuCat=array();
		$subCat=array();
		$subsubCat=array();
		?>
		<style>		
            .plx-cat mark {
              display: inline-block;
              background: none;
              float: left;
              rotate: -90deg;
              translate: -100%;
              transition:0.25s;
              margin-inline-end:-1em;
            }
            .plx-cat mark:before {
              content: '\2b9f';
            }
            .plx-cat ul {
              display: none
            }
            .plx-cat:hover  li:hover > ul {
              display:block
            }.plx-cat:hover  li:hover > mark {
              rotate:0deg;
            }
            ul:empty,li:empty,li>mark:first-child {
              display: none;
            }
		</style>
		<?php
		
            foreach($plxShow->plxMotor->aCats as $k => $ar) {
                // on recherche les catégories qui ne sont ni fille ni mére
                if($ar['mother'] =='0' && $ar['daughterOf'] =='000' && $ar['active'] =='1') {
                    $menuCat[$k] =$k;   
                }
                // on recherche les catégories uniquement mére
                if($ar['mother'] =='1' && $ar['active'] =='1') {
                    $menuCat[$k]=$k;
                }
                // on recherche les catégories qui  sont  fille et mére
                if($ar['mother'] =='0' && $ar['daughterOf'] !='000' && $ar['active'] =='1' ) {
                    $bothCat[$ar['daughterOf']][]=array($k=>$k);
                }
                // on recherche les catégories qui  sont  fille 
                if($ar['mother'] =='0' && $ar['daughterOf'] !='000' && $ar['active'] =='1' ) {
                    // fille de 3eme niveau
                    if ($plxShow->plxMotor->aCats[$ar['daughterOf']]['daughterOf'] !='000') {
                    $subsubCat[$ar['daughterOf']][]=$k;
                    }
                    else {
                    // fille de second niveau
                    $subCat[$ar['daughterOf']][]=$k;
                    }
                }
            }

            if($menuCat) {// on a un premier niveau, let's go
            echo '<'.$lvl1.' class="cat-list unstyled-list plx-cat">'.PHP_EOL;
            foreach($menuCat as $order => $category ) {
                echo '<'.$kid.'>'.PHP_EOL ;                     
                $plxShow->catList('','<a id="#cat_id" class="#cat_status" data-mother="#cat_mother" data-daughter="#data_daughter"  a href="#cat_url" title="#cat_name">#cat_name</a> '.PHP_EOL, $category); 
                if (array_key_exists($category,$subCat)) {
                echo "<$mark></$mark>";
                    echo '<'.$lvl2.' class="cat-list unstyled-list">'.PHP_EOL;
                        foreach($subCat[$category] as $k => $v ){
                        echo '<'.$kid.'>'.PHP_EOL ; 
                        $plxShow->catList('','<a id="#cat_id" class="#cat_status" data-mother="#cat_mother" data-daughter="#data_daughter"  a href="#cat_url" title="#cat_name">#cat_name</a>'.PHP_EOL, $v);
                            if (array_key_exists($v,$subsubCat)) {
                            echo "<$mark></$mark>";
                                echo '<'.$lvl3.' class="cat-list unstyled-list">';  
                                foreach($subsubCat[$v] as $ksub => $vsub ){
                                        $plxShow->catList('','<'.$kid.'><a id="#cat_id" class="#cat_status" data-mother="#cat_mother" data-daughter="#data_daughter"  a href="#cat_url" title="#cat_name">#cat_name</a></'.$kid.'>'.PHP_EOL, $v );
										// affichage derniers articles categorie
										echo '<ul>';
										if($plxShow->plxMotor->aCats[$ksub]['articles'] > 0 ){
										echo'<li><small>'.$plxShow->getLang('LATEST_ARTICLES').'</small></li>';
										$plxShow->lastArtList('	<li class="#art_status"><a href="#art_url" title="#art_title">#art_title</a></li>',3, intval($subsubCat[$v][$vsub]));
										}
										else {
										echo'<li><small>'.L_NO_ARTICLE.'</small></li>';
										}
										echo '</ul>';
                                }
                                echo "</$lvl3>".PHP_EOL;
                            }
							else {// affichage derniers articles categorie
							echo '<ul>';
							if($plxShow->plxMotor->aCats[$v]['articles'] > 0 ){
							echo '<li><small>'.$plxShow->getLang('LATEST_ARTICLES').'</small></li>';
                            $plxShow->lastArtList('	<li class="#art_status"><a href="#art_url" title="#art_title">#art_title</a></li>',3, intval($v));
							}
							else {
							echo'<li><small>'.L_NO_ARTICLE.'</small></li>';
							}
							echo '</ul>';
							}
                        echo '</'.$kid.'>'.PHP_EOL ;    
                        }
                    echo "</$lvl2>".PHP_EOL;
                    }
					else {// affichage derniers articles categorie
							echo '<ul>';
							if($plxShow->plxMotor->aCats[$order]['articles'] > 0 ){
							echo '<li><small>'.$plxShow->getLang('LATEST_ARTICLES').'</small></li>';
                            $plxShow->lastArtList('	<li class="#art_status"><a href="#art_url" title="#art_title">#art_title</a></li>',3, intval($order));
							}
							else {
							echo'<li><small>'.L_NO_ARTICLE.'</small></li>';
							}
							echo '</ul>';					
					}
                echo '</'.$kid.'>'.PHP_EOL;
                }
            echo "</$lvl1>".PHP_EOL;
            }
        }
            else { // pas de plugin categories activé on repasse en affichage natif
            ?>
                <ul class="cat-list unstyled-list">
                <?php
        $plxShow->catList('','<li id="#cat_id" class="#cat_status" data-mother="#cat_mother" data-daughter="#data_daughter"><a href="#cat_url" title="#cat_name">#cat_name</a> <span> (#art_nb)</span></li>'); 
        ?>
                </ul>
                <?php
        }
        ?>

		<h3>
			<?php $plxShow->lang('LATEST_ARTICLES'); ?>
		</h3>

		<ul class="lastart-list unstyled-list">
			<?php $plxShow->lastArtList('<li><a class="#art_status" href="#art_url" title="#art_title">#art_title</a></li>'); ?>
		</ul>

		<h3>
			<?php $plxShow->lang('TAGS'); ?>
		</h3>

		<ul class="tag-list">
			<?php $plxShow->tagList('<li class="tag #tag_size"><a class="#tag_status" href="#tag_url" title="#tag_name">#tag_name</a></li>', 20); ?>
		</ul>

		<h3>
			<?php $plxShow->lang('LATEST_COMMENTS'); ?>
		</h3>

		<ul class="lastcom-list unstyled-list">
			<?php $plxShow->lastComList('<li><a href="#com_url">#com_author '.$plxShow->getLang('SAID').' : #com_content(34)</a></li>'); ?>
		</ul>

		<h3>
			<?php $plxShow->lang('ARCHIVES'); ?>
		</h3>

		<ul class="arch-list unstyled-list">
			<?php $plxShow->archList('<li id="#archives_id"><a class="#archives_status" href="#archives_url" title="#archives_name">#archives_name</a> (#archives_nbart)</li>'); ?>
		</ul>

	</aside>