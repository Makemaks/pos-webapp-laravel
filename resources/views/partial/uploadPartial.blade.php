
 <div>
    @error('content_project_id')
        <div class="uk-text-danger">{{ $message }}</div>
    @enderror              
    
  
   <div class="uk-margin">
      <div  uk-form-custom="target: true">
           <input name="file" type="file"  id="file"/>
           <input class="uk-input uk-width-medium" type="text" placeholder="Select file" disabled>
         
      </div>
      <button type="submit" class="uk-border-rounded uk-button uk-button-default" uk-icon="icon: upload"></button>
      <p class="uk-text-meta uk-margin-remove-top"><i>Maximum file size is 1024MB. File type must be xls,xlsx,csv</i></p>
   </div>
  
   @error('content_location')
       <div class="uk-text-danger">{{ $message }}</div>
   @enderror
</div>