<div class="grid">
    {foreach from=$winningTickets item=tickets key=prizeAmount}
        <div>
            <h3>${$prizeAmount}:</h3>
            <table>
                <tr>
                    <td>Winning number</td>
                    <td>Username</td>
                </tr>
                {foreach from=$tickets item=winners key=winningNumber}
                    <tr>
                        <td>{$winningNumber}</td>
                        <td>
                            {if $winners }
                                <ul>
                                    {foreach from=$winners item=winner}
                                        <li>{$winner}</li>
                                    {/foreach}
                                </ul>
                            {else}
                                -
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>
    {/foreach}
</div>
