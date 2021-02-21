<div>


    @if(!$form)
        <div class="pb-2">
            <button class="btn btn-sm btn-dark" wire:click="createForm">Create</button>
        </div>
    @endif
    @if($form)

        <div class="pb-2">
            <button class="btn btn-sm btn-dark" wire:click="backTable">Back</button>
        </div>

        <div class="card ">

            @if($action=="modify")
                <div class="card-header">Modify User</div>
            @else
                <div class="card-header">Create User</div>
            @endif
            <div class="card-body">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" wire:model="form_nickname" placeholder="Name of User" required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" wire:model="form_username"  placeholder="username" required>
                </div>
                @if($action!="modify")

                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" class="form-control" wire:model="form_password"  placeholder="*******" required>
                    </div>

                @endif
                <div class="form-group">
                    <label>Level </label>
                    <select wire:model="form_level" class="form-control">
                        <option value="M">Master Admin</option>
                        <option value="A">Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Project Reality Hash (Beta) </label>
                    <input type="email" class="form-control" wire:model="form_hash"  placeholder="Project Reality Hash">
                </div>

            </div>
            <div class="card-footer">

                @if($action=="modify")
                    <button wire:click="updateEntity" class="btn btn-primary">Update</button>
                @else
                    <button wire:click="createEntity" class="btn btn-primary">Create</button>
                @endif

            </div>
        </div>

    @else


        <div class="card ">
            <div class="card-header">Admin users</div>
            <div class="">
                <table class="table shadow-sm mb-0 bg-white  table-hover" >
                    <thead class="thead-light">
                    <tr>
                        <th>Nickname</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Hash</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->nickname }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                                @if($user->level=="M")
                                    <span class="text-danger">Master</span>
                                @else
                                    <span class="text-primary">Admin</span>
                                @endif
                            </td>
                            <td>{{ $user->hash ?: '--' }}</td>
                            <td>

                                <button type="button" wire:click="viewEntity({{ $user->id }})" class="btn btn-link btn-sm p-0" >
                                    <span class="fa fa-edit"></span> Modify
                                </button>

                                <button type="button" wire:click="removeAdmin({{ $user->id }})" class="btn btn-link btn-sm p-0 float-lg-right" >
                                    <span class="fa fa-trash"></span> Destroy
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

    @endif

</div>
