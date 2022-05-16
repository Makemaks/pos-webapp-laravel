
@php
use App\Models\Setting;
use App\Models\Address;
use App\Models\Project;


@endphp

<div class="">


<div class="uk-margin">
  <label class="uk-form-label">Logo</label>
    <input type="file" class="uk-input" name="setting_logo_url">
</div>

<div class="uk-margin">
    <input placeholder="Setting Vat" type="text" class="uk-input" name="setting_vat" value="{{ old('setting_vat', $data['settingModel']->setting_vat) }}"/>

</div>

<div class="uk-margin">

  <input type="hidden" id="project_type" name="setting_project_type" />

  <div id="setting_project_type">

  </div>

  <script>

    var settingProjectType = jSuites.tags(document.getElementById('setting_project_type'), {
      placeholder: 'Project Type',
      value: '{{ old('setting_project_type', $data['settingModel']->setting_project_type) }}'
    });

    document.getElementById('setting_project_type').addEventListener('keydown', function(event) {

            console.log('Tags-type: ' + this.value);
            document.getElementById('project_type').value = this.value;

      });


      var project_type_model = '{{ $data['settingModel']->setting_project_type}}';

      if(typeof project_type_model !== 'undefined'){

          $(window).load(function(){
            console.log(settingProjectType.getValue());
            document.getElementById('project_type').value= settingProjectType.getValue();
          });


      }

  </script>


{{-- @if($data['settingModel']->setting_project_type)
<script>
  $(document).ready(function(){
    jSuites.tags(document.getElementById('setting_project_type'), {
      placeholder: 'Project Type',
      value: '{{ old('setting_project_type', $data['settingModel']->setting_project_type) }}'
    });

    document.getElementById('setting_project_type').addEventListener('keydown', function(event) {

            console.log('Tags-type: ' + this.value);
            document.getElementById('project_type').value = this.value;

      });
  });
  console.log(($'#setting_project_type .jtags_label'));
    //console.log(document.getElementById('setting_project_type'));
</script>

@endif --}}
  {{-- <input placeholder="Project Stage" type="text" class="uk-input" name="setting_project_stage" value="{{ old('setting_project_stage', $data['settingModel']->setting_project_stage) }}"/> --}}

</div>

<div class="uk-margin">



  <div id="setting_project_stage">

  </div>
  <input type="hidden" id="project_stage" name="setting_project_stage" />
  <script>
    var settingProjectStage = jSuites.tags(document.getElementById('setting_project_stage'), {
      placeholder: 'Project Stage',
      value: '{{ old('setting_project_stage', $data['settingModel']->setting_project_stage) }}'
    });

    document.getElementById('setting_project_stage').addEventListener('keydown', function(event) {

            console.log('Tags-stage: ' + this.value);
            document.getElementById('project_stage').value = this.value;

      });

      var project_stage_model = '{{ $data['settingModel']->setting_project_stage}}';

if(typeof project_stage_model !== 'undefined'){

    $(window).load(function(){
      console.log(settingProjectStage.getValue());
      document.getElementById('project_stage').value= settingProjectStage.getValue();
    });


}
  </script>


    {{-- <input placeholder="Project Type" type="text" class="uk-input" name="setting_project_type[]" value=""/> --}}

  </div>



<div class="uk-margin">

<input id="product_category" type="hidden"  name="setting_product_category" />
<div id="setting_product_category">

</div>

<script>
  var settingProductCategory = jSuites.tags(document.getElementById('setting_product_category'), {
    placeholder: 'Product Category',
    value: '{{ old('setting_product_category', $data['settingModel']->setting_product_category) }}'
  });

  document.getElementById('setting_product_category').addEventListener('keydown', function(event) {

          console.log('Tags-category: ' + this.value);
          document.getElementById('product_category').value = this.value;

    });

    var product_category_model = '{{ $data['settingModel']->setting_product_category}}';

if(typeof product_category_model !== 'undefined'){

    $(window).load(function(){
      console.log(settingProductCategory.getValue());
      document.getElementById('product_category').value= settingProductCategory.getValue();
    });


}
</script>
</div>


</div>
<script>


  </script>


