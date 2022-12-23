<?php include __DIR__.'/header.php'; ?>

	<main class="main">

		<div class="container">

			<div class="grid">

				<div class="content col sml-12 med-9">

					<?php while($plxShow->plxMotor->plxRecord_arts->loop()): ?>

					<article class="article" id="post-<?php echo $plxShow->artId(); ?>" role="article">

						<header>
							<span class="art-date">
								<time datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>">
									<?php $plxShow->artDate('#num_day #month #num_year(4)'); ?>
								</time>
							</span>
							<h2>
								<?php $plxShow->artTitle('link'); ?>
							</h2>
							<div>
								<small>
									<span class="written-by">
										<?php $plxShow->lang('WRITTEN_BY'); ?> <?php $plxShow->artAuthor() ?>
									</span>
									<span class="art-nb-com">
										<?php $plxShow->artNbCom(); ?>
									</span>
								</small>
							</div>
							<div>
								<small>
									<span class="classified-in">
										<?php $plxShow->lang('CLASSIFIED_IN') ?> : <?php $plxShow->artCat() ?>
									</span>
									<span class="tags">
										<?php $plxShow->lang('TAGS') ?> : <?php $plxShow->artTags() ?>
									</span>
								</small>
							</div>
						</header>

						<?php $plxShow->artThumbnail(); ?>
						<?php $plxShow->artChapo(); ?>
						
						<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php echo $plxShow->plxMotor->plxRecord_arts->f('url'); ?>"
    },
    "headline": "<?php $plxShow->artTitle(); ?>",
    <?php if (trim($plxShow->plxMotor->plxRecord_arts->f('thumbnail'))): ?>
    "image": "<?php echo $plxShow->plxMotor->urlRewrite(trim($plxShow->plxMotor->plxRecord_arts->f('thumbnail'))); ?>",
    <?php endif; ?>
    "datePublished": "<?php $plxShow->artDate('#num_year(4)-#num_month-#num_dayT#hour:#minute:00+#time'); ?>",
    "dateModified": "<?php  echo plxDate::formatDate($plxShow->plxMotor->plxRecord_arts->f('date_update'), '#num_year(4)-#num_month-#num_dayT#hour:#minute:00+#time') ?>",
    "author": {
        "@type": "Person",
        "name": "<?php $plxShow->artAuthor() ?>"
    }
    <?php if (trim($plxShow->plxMotor->plxRecord_arts->f('tags'))): ?>
    ,"keywords":"<?php $plxShow->artTags('#tag_name ') ?>"
    <?php endif; ?>
}
</script>	<!-- -->						
						

					</article>

					<?php endwhile; ?>

					<nav class="pagination text-center">
						<?php $plxShow->pagination(); ?>
					</nav>

					<?php $plxShow->artFeed('rss',$plxShow->catId(), '<span><a href="#feedUrl" title="#feedTitle">#feedName</a></span>'); ?>

				</div>

				<?php include __DIR__.'/sidebar.php'; ?>

			</div>

		</div>

	</main>

<?php include __DIR__.'/footer.php'; ?>
