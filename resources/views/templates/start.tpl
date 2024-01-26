{extends file='base.tpl'}
{block name=body}
    <form action="/launch" method="GET" style="width:25%">
        <div>
            <label for="username">
                From
                <input type="date" name="date_from" required>
            </label>
            <label for="user_number">
                To
                <input type="date" name="date_to" required >
            </label>
            <button type="submit">Start a lottery</button>
        </div>
    </form>
{/block}
