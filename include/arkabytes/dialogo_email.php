<div id="dialogo_email" title="Enviar E-mail">
    <div id="email_destino"></div>
    <form id="form_enviar_email" method="post" action="run/_enviar_email.php">
    <fieldset style="margin-top:5px">
    <ol>
    <li>
        <label>Para</label>
        <input type="text" name="para" id="para" readonly="readonly" size="40"/>
    </li>
    <li>
        <label>Asunto</label>
        <input type="text" name="asunto" id="asunto" size="40"/>
    </li>
    <li>
        <label>Mensaje</label>
        <textarea cols="40" rows="5" name="mensaje" id="mensaje"></textarea>
    </li>
    </ol>
    </fieldset>
    </form>
    <div id="resultado_enviar_email"></div>
</div>