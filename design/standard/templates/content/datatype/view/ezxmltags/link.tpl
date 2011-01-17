{def $userformail=fetch( 'user', 'current_user' )}
{if and($userformail.is_logged_in|not(),$href|extract_left( 7 )|compare('mailto:'))}
	{if is_set($id)|not()}{def $id=''}{/if}
	{if is_set($title)|not()}{def $title=''}{/if}
	{if is_set($target)|not()}{def $target=''}{/if}
	{if is_set($classification)|not()}{def $classification=''}{/if}
	{if is_set($hreflang)|not()}{def $hreflang=''}{/if}
	{if is_set($content)|not()}{def $content=''}{/if}	
	{mailhide($href, $id, $title, $target, $classification, $hreflang, $content)}	
	{undef}
{else}
	<a href={$href|ezurl}{if $id} id="{$id}"{/if}{if $title} title="{$title}"{/if}{if $target} target="{$target}"{/if}{if $classification} class="{$classification|wash}"{/if}{if and(is_set( $hreflang ), $hreflang)} hreflang="{$hreflang|wash}"{/if}>{$content}</a>
{/if}
{undef}