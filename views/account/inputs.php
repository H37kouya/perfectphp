<table class="uk-table uk-width-large">
    <tbody>
        <tr>
            <th>ユーザーID</th>
            <td>
                <input type="text" name="user_name" value="<?php echo $this->escape($user_name); ?>" class="uk-input">
            </td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td>
                <input type="password" name="password" value="<?php echo $this->escape($password); ?>" class="uk-input">
            </td>
        </tr>
    </tbody>
</table>
