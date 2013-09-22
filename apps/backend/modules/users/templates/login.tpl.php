<div id="backDoor">
    <?php echo form_tag( 'post', CITRUS_PROJECT_URL . 'backend/login', array( 'id' => 'loginForm' ) ) ?>
        <div class="form-group">
            <input type="text" name="email" value="" id="login" class="required" placeholder="E-mail">
        </div>
        <div class="form-group">
            <input type="password" name="password" value="" id="password" class="required" placeholder="password">
        </div>
		
        <p style="text-align:center;">
			<button class="btn btn-default" type="submit">Connexion</button><br/>
        </p>
    </form>
    <div class="merci-ie"></div>
</div>