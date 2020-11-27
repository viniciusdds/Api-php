<style>
#pass {
  width: 150px;
  padding-right: 20px;
}

.olho {
  cursor: pointer;
  left: 160px;
  position: absolute;
  width: 20px;
}
</style>
<img src="https://cdn0.iconfinder.com/data/icons/ui-icons-pack/100/ui-icon-pack-14-512.png" id="olho" class="olho">
<input type="password" id="pass">
<script>
document.getElementById('olho').addEventListener('mousedown', function() {
  document.getElementById('pass').type = 'text';
});

document.getElementById('olho').addEventListener('mouseup', function() {
  document.getElementById('pass').type = 'password';
});

// Para que o password não fique exposto apos mover a imagem.
document.getElementById('olho').addEventListener('mousemove', function() {
  document.getElementById('pass').type = 'password';
});
</script>