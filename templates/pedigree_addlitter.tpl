<{if $sire}>
	<{include file="db:pedigree_result.tpl" numofcolumns=$numofcolumns nummatch=$nummatch pages=$pages columns=$columns dogs=$dogs}>
<{/if}>

<{if $form}>
	<{$form}>
	<table width='100%' class='outer' cellspacing='1'>
		<tr>
			<th colspan='3'><{$formtit}></th>
		</tr>
		<tr class="head">
			<td>
				No.
			</td>
			<td>
				Name
			</td>
			<td>
				Gender
			</td>
		</tr>
		<{foreach item=link from=$dogs}>
		<tr class="<{cycle values="even,odd"}>">
			<td>
				<{$link.number}>
			</td>
			<td>
				<{$link.name}>
			</td>
			<td>
				<{$link.gender}>
			</td>

		</tr>
		<{/foreach}>

		<tr class="odd">
			<td colspan="3">
				<{$submit}>
			</td>
		</tr>
	</table>
	
<{/if}>

