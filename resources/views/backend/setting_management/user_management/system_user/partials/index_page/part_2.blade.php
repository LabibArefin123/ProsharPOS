 <div class="table-responsive">
     <table class="table system-users-table mb-0">
         <thead>
             <tr>
                 <th>#</th>
                 <th>Profile</th>
                 <th>Role</th>
                 <th>Name</th>
                 <th>Email</th>
                 <th>Phone 1</th>
                 <th>Phone 2</th>
                 <th>Username</th>
                 <th>Password</th>
                 <th>Actions</th>
             </tr>
         </thead>

         <tbody>
             @forelse ($users as $user)
                 <tr>
                     <td class="user-serial">
                         {{ $loop->iteration }}
                     </td>

                     <td>
                         <div class="user-profile-cell">
                             <img src="{{ asset($user->profile_picture ?: 'uploads/images/default.jpg') }}"
                                 alt="{{ $user->name }}" class="user-profile-image"
                                 onerror="this.onerror=null;this.src='{{ asset('uploads/images/default.jpg') }}';">
                         </div>
                     </td>

                     <td>
                         <div class="user-role-list">
                             @forelse ($user->roles as $role)
                                 <span class="user-role-badge">
                                     {{ $role->name }}
                                 </span>
                             @empty
                                 <span class="user-empty-value">No Role</span>
                             @endforelse
                         </div>
                     </td>

                     <td>
                         <span class="user-name">{{ $user->name }}</span>
                     </td>

                     <td>
                         <span class="user-email">{{ $user->email }}</span>
                     </td>

                     <td>{{ $user->phone ?? 'Not Provided' }}</td>
                     <td>{{ $user->phone_2 ?? 'Not Provided' }}</td>

                     <td>
                         <span class="user-username">
                             {{ $user->username ?? 'Not Provided' }}
                         </span>
                     </td>

                     <td>
                         <span class="user-password-value">
                             {{ $user->decrypted_password ?? 'Not Provided' }}
                         </span>
                     </td>

                     <td>
                         <div class="user-action-group">
                             <a href="{{ route('system_users.show', $user->id) }}"
                                 class="user-action-btn user-view-btn" title="View User">
                                 <i class="fas fa-eye"></i>
                             </a>

                             <a href="{{ route('system_users.edit', $user->id) }}"
                                 class="user-action-btn user-edit-btn" title="Edit User">
                                 <i class="fas fa-edit"></i>
                             </a>

                             @if (auth()->user()->hasRole('admin'))
                                 <button type="button" class="user-action-btn user-password-btn change-password-btn"
                                     data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                     data-user-email="{{ $user->email }}"
                                     data-user-username="{{ $user->username ?? 'Not Provided' }}"
                                     data-user-picture="{{ asset($user->profile_picture ?: 'uploads/images/default.jpg') }}"
                                     title="Change Password">

                                     <i class="fas fa-key"></i>
                                 </button>
                             @endif
                             @if (auth()->user()->hasRole('admin'))
                                 <form action="{{ route('system_users.destroy', $user->id) }}" method="POST"
                                     class="user-delete-form"
                                     onsubmit="return confirm('Are you sure you want to delete {{ addslashes($user->name) }}? This action cannot be undone.');">

                                     @csrf
                                     @method('DELETE')

                                     <button type="submit" class="user-action-btn user-delete-btn" title="Delete User">

                                         <i class="fas fa-trash-alt"></i>
                                     </button>
                                 </form>
                             @endif
                         </div>
                     </td>
                 </tr>
             @empty
                 <tr>
                     <td colspan="10">
                         <div class="system-users-empty">
                             <i class="fas fa-users-slash"></i>
                             <h5>No Users Found</h5>
                             <p>There are currently no system users available.</p>
                         </div>
                     </td>
                 </tr>
             @endforelse
         </tbody>
     </table>
 </div>
