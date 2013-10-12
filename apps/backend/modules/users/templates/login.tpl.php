<div id="backDoor">
    <?php echo form_tag( 'post', CITRUS_PROJECT_URL . 'backend/login', array( 'id' => 'loginForm' ) ) ?>
        <div class="form-group">
            <input type="email" name="email" value="" id="login" required class="form-control" placeholder="E-mail">
        </div>
        <div class="form-group">
            <input type="password" name="password" value="" id="password" required class="form-control" placeholder="password">
        </div>
		
        <p style="text-align:center;">
			<button class="btn btn-default" type="submit">Connexion</button><br/>
        </p>
    </form>
    <div class="merci-ie"></div>
</div>