<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_Rol&mode={{mode}}&rol_id={{rol_id}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
    <label for="rol_id" class="col-4">Código</label>
    <input type="hidden" id="rol_id" name="rol_id" value="{{rol_id}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
    <input type="hidden"  name="xssToken" value="{{xssToken}}"/>
    <input type="text" readonly name="rol_iddummy" value="{{rol_id}}"/>
    </section>


    <section class="row">
      <label for="rol_dsc" class="col-4">Rol</label>
      <input type="text" {{readonly}} name="rol_dsc" value="{{rol_dsc}}" required/>
    </section>


    <section class="row">
      <label for="rol_est" class="col-4">Estado</label>
      <select id="rol_est" name="rol_est" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{rol_est_ACT}}>Activo</option>
        <option value="INA" {{rol_est_INA}}>Inactivo</option>
      </select>
    </section>





    {{if has_errors}}
        <section>
          <ul>
            {{foreach general_errors}}
                <li>{{this}}</li>
            {{endfor general_errors}}
          </ul>
        </section>
    {{endif has_errors}}
    <section>
      {{if show_action}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif show_action}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=Mnt_Roles");
      });
  });
</script>
