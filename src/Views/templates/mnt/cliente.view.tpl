<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_Clientes&mode={{mode}}&clientid={{clientid}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
    <label for="catid" class="col-4">Código</label>
    <input type="hidden" id="catid" name="catid" value="{{clientid}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
    <input type="hidden"  name="xssToken" value="{{xssToken}}"/>
    <input type="text" readonly name="catiddummy" value="{{clientid}}"/>
    </section>
    <section class="row">
      <label for="clientname" class="col-4">Categoría</label>
      <input type="text" {{readonly}} name="clientname" value="{{clientname}}" maxlength="45" placeholder="Nombre de Categoría"/>
      {{if clientname_error}}
        <span class="error col-12">{{clientname_error}}</span>
      {{endif clientname_error}}
    </section>
    <section class="row">
      <label for="clientstatus" class="col-4">Estado</label>
      <select id="clientstatus" name="clientstatus" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{clientstatus_ACT}}>Activo</option>
        <option value="INA" {{clientstatus_INA}}>Inactivo</option>
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
        window.location.assign("index.php?page=Mnt_Clientes");
      });
  });
</script>
