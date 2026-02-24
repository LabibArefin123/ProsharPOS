   {{-- User --}}
   <div class="col-md-6 form-group">
       <label><strong>User's Name</strong> <span class="text-danger">*</span></label>
       <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
           <option value="">Select User</option>
           @foreach ($users as $user)
               <option value="{{ $user->id }}"
                   {{ old('user_id', $petty_cash->user_id) == $user->id ? 'selected' : '' }}>
                   {{ $user->name }} ({{ $user->email }})
               </option>
           @endforeach
       </select>
       @error('user_id')
           <small class="text-danger">{{ $message }}</small>
       @enderror
   </div>
   <div class="form-group col-md-6">
       <label>User's Email</label>
       <input type="text" id="user-email" class="form-control" readonly>
   </div>
   <div class="form-group col-md-6">
       <label>User's Phone</label>
       <input type="text" id="user-phone" class="form-control" readonly>
   </div>
   <div class="form-group col-md-6">
       <label>User's Username</label>
       <input type="text" id="user-username" class="form-control" readonly>
   </div>
