{extends file='base.tpl'}
{block name=body}
    <h2>Total tickets: {$totalTicketCount}</h2>

    <h2>Results:</h2>
    {include file='table.tpl'}

{/block}
