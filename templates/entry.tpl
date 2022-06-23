{**
 * templates/content.tpl
 *
 * Display blog content
 *}
{include file="frontend/components/header.tpl" pageTitleTranslated=$title|escape}

<article class="container page-blog-post">
	<div class="row page-header justify-content-md-center">
		<div class="col-md-8">
		    <div class="blog-date">
			{$entry->getDatePosted()|date_format:"%B %e, %Y"}
		    </div>
			<h1>{$entry->getTitle()|escape}</h1>
				<div class="byline">
					{if null !== $entry->getByline() }By{/if} {$entry->getByline()|escape}
				</div>
		</div>
	</div>
	<div class="row justify-content-md-center blog-post-content">
		<div class="col-md-8">
			<article class="page-content blog-post-content">
			{$entry->getContent()}
    		</article>
		</div>
	</div>
	<div class="row justify-content-md-center blog-post-tags">
		<div class="col-md-8">
			<article class="page-content">
		{foreach from=$keywords item=word }
						<a class="btn" href="{url router=$smarty.const.ROUTE_PAGE page="blog" op="index" keyword="$word"}">{$word|escape}</a>
		{/foreach}
		</article>
		</div>
	</div>
</article>

{include file="frontend/components/footer.tpl"}
