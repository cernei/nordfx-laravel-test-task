{extends file='base.tpl'}
{block name=body}
    {if $message }
        <h1>Ticket added!</h1>
    {/if}
    <form action="/add" method="POST">
        <input type="hidden" name="_token" value="{$csrf}">
        <div>
            <label for="username">
                Username
                <input type="text" id="username" name="username" required>
            </label>
            <label for="user_number">
                Your lucky number
{*                min="1000000"  max="9999999"*}
                <input type="number" id="user_number" name="user_number" required >
            </label>
            <button type="submit">Buy a ticket</button>
        </div>
    </form>
    <h2>My tickets:</h2>
    {foreach from=$myTickets item=ticket}
        <li>{$ticket['user_number']}</li>
    {/foreach}
{/block}
