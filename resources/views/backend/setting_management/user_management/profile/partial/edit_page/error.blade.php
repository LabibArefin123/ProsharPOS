 @if ($errors->any())
     <div class="profile-validation-summary" id="profileValidationSummary">
         <div class="profile-validation-icon">
             <i class="fas fa-exclamation-triangle"></i>
         </div>

         <div>
             <strong>Please review the following information</strong>
             <ul>
                 @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                 @endforeach
             </ul>
         </div>
     </div>
 @endif
