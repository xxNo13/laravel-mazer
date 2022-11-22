<div>
    @if (isset($selected))
        {{-- Add Output/Suboutput/Target Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddIPCROSTModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add Output/Suboutput/Target</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="mt-3 form-group d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="output"
                                        value="sub_funct" name="selected" wire:model="selected">
                                    <label class="form-check-label" for="sub_funct">
                                        Sub Function
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="output"
                                        value="output" name="selected" wire:model="selected">
                                    <label class="form-check-label" for="output">
                                        Output
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="suboutput"
                                        value="suboutput" name="selected" wire:model="selected">
                                    <label class="form-check-label" for="suboutput">
                                        Suboutput
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="target"
                                        value="target" name="selected" wire:model="selected">
                                    <label class="form-check-label" for="target">
                                        Target
                                    </label>
                                </div>
                            </div>

                            <hr>

                            <div class="mt-3">
                                @if ($selected == 'sub_funct')
                                    <label>Sub Function: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Sub Function" class="form-control"
                                            wire:model="sub_funct">
                                        @error('sub_funct')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'output')
                                    <label>Sub Function (Optional): </label>
                                    <div class="form-group">
                                        <select placeholder="Sub Function" class="form-control"
                                            wire:model="sub_funct_id">
                                            <option value="">Select a Sub Function</option>
                                            @if ($userType == 'faculty')
                                                @foreach ($subFuncts as $sub_funct)
                                                    @if ($sub_funct->type == 'ipcr' && $sub_funct->duration_id == $duration->id && $sub_funct->user_type == $userType)
                                                        <option value="{{ $sub_funct->id }}">
                                                            {{ $sub_funct->sub_funct }}</option>
                                                    @endif
                                                @endforeach
                                            @elseif ($userType == 'facult')
                                                @foreach (Auth::user()->subFuncts as $sub_funct)
                                                    @if ($sub_funct->isDesignated && $sub_funct->type == 'ipcr' && $sub_funct->duration_id == $duration->id && $sub_funct->user_type == 'faculty')
                                                        <option value="{{ $sub_funct->id }}">{{ $sub_funct->sub_funct }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach (Auth::user()->subFuncts as $sub_funct)
                                                    @if ($sub_funct->type == 'ipcr' && $sub_funct->duration_id == $duration->id && $sub_funct->user_type == $userType)
                                                        <option value="{{ $sub_funct->id }}">{{ $sub_funct->sub_funct }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('output_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Output" class="form-control" name="output"
                                            wire:model="output">
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'suboutput')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <select placeholder="Output" class="form-control" wire:model="output_id"
                                            required>
                                            <option value="">Select an output</option>
                                            @if ($userType == 'faculty')
                                                @foreach ($outputs as $output)
                                                    @forelse ($output->targets as $target)
                                                    @empty
                                                        <option value="{{ $output->id }}">{{ $output->code }}
                                                            {{ $output->output }}
                                                        </option>
                                                    @endforelse
                                                @endforeach
                                            @elseif ($userType == 'facult')
                                                @foreach (Auth::user()->outputs as $output)
                                                    @forelse ($output->targets as $target)
                                                    @empty
                                                        @if ($output->isDesignated && $output->type == 'ipcr' && $output->duration_id == $duration->id && $output->user_type == 'faculty')
                                                            <option value="{{ $output->id }}">{{ $output->code }}
                                                                {{ $output->output }}
                                                            </option>
                                                        @endif
                                                    @endforelse
                                                @endforeach
                                            @else
                                                @foreach (Auth::user()->outputs as $output)
                                                    @forelse ($output->targets as $target)
                                                    @empty
                                                        @if ($output->type == 'ipcr' && $output->duration_id == $duration->id && $output->user_type == $userType)
                                                            <option value="{{ $output->id }}">{{ $output->code }}
                                                                {{ $output->output }}
                                                            </option>
                                                        @endif
                                                    @endforelse
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('output_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Suboutput: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Suboutput" class="form-control"
                                            name="suboutput" wire:model="suboutput">
                                        @error('suboutput')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'target')
                                    <label>Output/Suboutput: </label>
                                    <div class="form-group">
                                        <select placeholder="Output/Suboutput" class="form-control" wire:model="subput"
                                            required>
                                            <option value="">Select an/a output/suboutput</option>
                                            @if ($userType == 'faculty')
                                                @foreach ($outputs as $output)
                                                    @forelse ($output->suboutputs as $suboutput)
                                                    @empty
                                                        <option value="output, {{ $output->id }}">
                                                            {{ $output->code }}
                                                            {{ $output->output }}
                                                        </option>
                                                    @endforelse
                                                @endforeach
                                                @foreach ($suboutputs as $suboutput)
                                                    <option value="suboutput, {{ $suboutput->id }}">
                                                        {{ $suboutput->output->code }}
                                                        {{ $suboutput->output->output }} -
                                                        {{ $suboutput->suboutput }}
                                                    </option>
                                                @endforeach
                                            @elseif ($userType == 'facult')
                                                @foreach (Auth::user()->outputs as $output)
                                                    @forelse ($output->suboutputs as $suboutput)
                                                    @empty
                                                        @if ($output->isDesignated && $output->type == 'ipcr' && $output->duration_id == $duration->id && $output->user_type == 'faculty')
                                                            <option value="output, {{ $output->id }}">
                                                                {{ $output->code }}
                                                                {{ $output->output }}
                                                            </option>
                                                        @endif
                                                    @endforelse
                                                @endforeach
                                                @foreach (Auth::user()->suboutputs as $suboutput)
                                                    @if ($suboutput->isDesignated && $suboutput->type == 'ipcr' && $suboutput->duration_id == $duration->id && $suboutput->user_type == 'faculty')
                                                        <option value="suboutput, {{ $suboutput->id }}">
                                                            {{ $suboutput->output->code }}
                                                            {{ $suboutput->output->output }} -
                                                            {{ $suboutput->suboutput }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach (Auth::user()->outputs as $output)
                                                    @forelse ($output->suboutputs as $suboutput)
                                                    @empty
                                                        @if ($output->type == 'ipcr' && $output->duration_id == $duration->id && $output->user_type == $userType)
                                                            <option value="output, {{ $output->id }}">
                                                                {{ $output->code }}
                                                                {{ $output->output }}
                                                            </option>
                                                        @endif
                                                    @endforelse
                                                @endforeach
                                                @foreach (Auth::user()->suboutputs as $suboutput)
                                                    @if ($suboutput->type == 'ipcr' && $suboutput->duration_id == $duration->id && $suboutput->user_type == $userType)
                                                        <option value="suboutput, {{ $suboutput->id }}">
                                                            {{ $suboutput->output->code }}
                                                            {{ $suboutput->output->output }} -
                                                            {{ $suboutput->suboutput }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('subput')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Target: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Target" class="form-control"
                                            name="target" wire:model="target">
                                        @error('target')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Output/Suboutput/Target Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditIPCROSTModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Output/Suboutput/Target</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="update">
                        <div class="modal-body">
                            <div class="mt-3">
                                @if ($selected == 'sub_funct')
                                    <label>Sub Function: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Sub Function" class="form-control"
                                            wire:model="sub_funct">
                                        @error('sub_funct')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'output')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Output" class="form-control" name="output"
                                            wire:model="output">
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'suboutput')
                                    <label>Suboutput: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Suboutput" class="form-control"
                                            name="suboutput" wire:model="suboutput">
                                        @error('suboutput')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'target')
                                    <label>Target: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Target" class="form-control"
                                            name="target" wire:model="target">
                                        @error('target')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Add Output/Suboutput/Target Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddOPCROSTModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add Output/Suboutput/Target</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="mt-3 form-group d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="output"
                                        value="sub_funct" name="selected" wire:model="selected">
                                    <label class="form-check-label" for="sub_funct">
                                        Sub Function
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="output"
                                        value="output" name="selected" wire:model="selected">
                                    <label class="form-check-label" for="output">
                                        Output
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="suboutput"
                                        value="suboutput" name="selected" wire:model="selected">
                                    <label class="form-check-label" for="suboutput">
                                        Suboutput
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="target"
                                        value="target" name="selected" wire:model="selected">
                                    <label class="form-check-label" for="target">
                                        Target
                                    </label>
                                </div>
                            </div>

                            <hr>

                            <div class="mt-3">
                                @if ($selected == 'sub_funct')
                                    <label>Sub Function: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Sub Function" class="form-control"
                                            wire:model="sub_funct">
                                        @error('sub_funct')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'output')
                                    <label>Sub Function (Optional): </label>
                                    <div class="form-group">
                                        <select placeholder="Sub Function" class="form-control"
                                            wire:model="sub_funct_id">
                                            <option value="">Select a Sub Function</option>
                                            @foreach (Auth::user()->subFuncts as $sub_funct)
                                                @if ($sub_funct->type == 'opcr' && $sub_funct->duration_id == $duration->id && $sub_funct->user_type == $userType)
                                                    <option value="{{ $sub_funct->id }}">{{ $sub_funct->sub_funct }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('output_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Output" class="form-control" name="output"
                                            wire:model="output">
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'suboutput')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <select placeholder="Output" class="form-control" wire:model="output_id"
                                            required>
                                            <option value="">Select an output</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @forelse ($output->targets as $target)
                                                @empty
                                                    @if ($output->type == 'opcr' && $output->duration_id == $duration->id && $output->user_type == $userType)
                                                        <option value="{{ $output->id }}">{{ $output->code }}
                                                            {{ $output->output }}
                                                        </option>
                                                    @endif
                                                @endforelse
                                            @endforeach
                                        </select>
                                        @error('output_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Suboutput: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Suboutput" class="form-control"
                                            name="suboutput" wire:model="suboutput">
                                        @error('suboutput')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'target')
                                    <label>Output/Suboutput: </label>
                                    <div class="form-group">
                                        <select placeholder="Output/Suboutput" class="form-control" wire:model="subput"
                                            required>
                                            <option value="">Select an/a output/suboutput</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @forelse ($output->suboutputs as $suboutput)
                                                @empty
                                                    @if ($output->type == 'opcr' && $output->duration_id == $duration->id && $output->user_type == $userType)
                                                        <option value="output, {{ $output->id }}">
                                                            {{ $output->code }}
                                                            {{ $output->output }}
                                                        </option>
                                                    @endif
                                                @endforelse
                                            @endforeach
                                            @foreach (Auth::user()->suboutputs as $suboutput)
                                                @if ($suboutput->type == 'opcr' && $suboutput->duration_id == $duration->id && $suboutput->user_type == $userType)
                                                    <option value="suboutput, {{ $suboutput->id }}">
                                                        {{ $suboutput->output->code }}
                                                        {{ $suboutput->output->output }} -
                                                        {{ $suboutput->suboutput }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('subput')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Target: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Target" class="form-control"
                                            name="target" wire:model="target">
                                        @error('target')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Alloted Budget: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Alloted Budget" class="form-control"
                                            name="alloted_budget" wire:model="alloted_budget">
                                        @error('alloted_budget')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Responsible Person/Office: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Responsible Person/Office" class="form-control"
                                            name="responsible" wire:model="responsible">
                                        @error('responsible')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Output/Suboutput/Target Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditOPCROSTModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Output/Suboutput/Target</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="update">
                        <div class="modal-body">
                            <div class="mt-3">
                                @if ($selected == 'sub_funct')
                                    <label>Sub Function: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Sub Function" class="form-control"
                                            wire:model="sub_funct">
                                        @error('sub_funct')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'output')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Output" class="form-control" name="output"
                                            wire:model="output">
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'suboutput')
                                    <label>Suboutput: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Suboutput" class="form-control"
                                            name="suboutput" wire:model="suboutput">
                                        @error('suboutput')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'target')
                                    <label>Target: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Target" class="form-control"
                                            name="target" wire:model="target">
                                        @error('target')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Alloted Budget: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Alloted Budget" class="form-control"
                                            name="alloted_budget" wire:model="alloted_budget">
                                        @error('alloted_budget')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Responsible Person/Office: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Responsible Person/Office" class="form-control"
                                            name="responsible" wire:model="responsible">
                                        @error('responsible')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="DeleteModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Delete Modal</h4>
                </div>
                <form wire:submit.prevent="delete">
                    <div class="modal-body">
                        <p>You sure you want to delete?</p>
                        <p>Can't recover data once you delete it!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-danger ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Delete</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (isset($type))
        {{-- Add Rating Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddRatingModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add Rating</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveRating('{{ 'add' }}')">
                        <div class="modal-body">
                            <label>Actual Accomplishment: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Actual Accomplishment" class="form-control"
                                    wire:model="accomplishment">
                                @error('accomplishment')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Efficiency: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Efficiency" class="form-control"
                                    wire:model="efficiency">
                                @error('efficiency')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Quality: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Quality" class="form-control"
                                    wire:model="quality">
                                @error('quality')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Timeliness: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Timeliness" class="form-control"
                                    wire:model="timeliness">
                                @error('timeliness')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Rating Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditRatingModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Rating</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveRating('{{ 'edit' }}')">
                        <div class="modal-body">
                            <label>Actual Accomplishment: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Actual Accomplishment" class="form-control"
                                    wire:model="accomplishment">
                                @error('accomplishment')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Efficiency: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Efficiency" class="form-control"
                                    wire:model="efficiency">
                                @error('efficiency')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Quality: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Quality" class="form-control"
                                    wire:model="quality">
                                @error('quality')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Timeliness: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Timeliness" class="form-control"
                                    wire:model="timeliness">
                                @error('timeliness')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Add Standard Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddStandardModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Standard</h4>
                </div>
                <form wire:submit.prevent="save('{{ 'add' }}')">
                    <div class="modal-body">
                        <div class="d-flex justify-content-around gap-2">
                            <div class="w-100 text-center">Efficiency: </div>
                            <div class="vr"></div>
                            <div class="w-100 text-center">Quality: </div>
                            <div class="vr"></div>
                            <div class="w-100 text-center">Timeliness: </div>
                        </div>
                        <hr>

                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">5:</h5>
                                <input type="text" class="form-control" wire:model="eff_5">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">5:</h5>
                                <input type="text" class="form-control" wire:model="qua_5">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">5:</h5>
                                <input type="text" class="form-control" wire:model="time_5">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">4:</h5>
                                <input type="text" class="form-control" wire:model="eff_4">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">4:</h5>
                                <input type="text" class="form-control" wire:model="qua_4">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">4:</h5>
                                <input type="text" class="form-control" wire:model="time_4">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">3:</h5>
                                <input type="text" class="form-control" wire:model="eff_3">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">3:</h5>
                                <input type="text" class="form-control" wire:model="qua_3">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">3:</h5>
                                <input type="text" class="form-control" wire:model="time_3">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">2:</h5>
                                <input type="text" class="form-control" wire:model="eff_2">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">2:</h5>
                                <input type="text" class="form-control" wire:model="qua_2">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">2:</h5>
                                <input type="text" class="form-control" wire:model="time_2">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">1:</h5>
                                <input type="text" class="form-control" wire:model="eff_1">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">1:</h5>
                                <input type="text" class="form-control" wire:model="qua_1">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">1:</h5>
                                <input type="text" class="form-control" wire:model="time_1">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Standard Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditStandardModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Standard</h4>
                </div>
                <form wire:submit.prevent="save('{{ 'edit' }}')">
                    <div class="modal-body">
                        <div class="d-flex justify-content-around gap-2">
                            <div class="w-100 text-center">Efficiency: </div>
                            <div class="vr"></div>
                            <div class="w-100 text-center">Quality: </div>
                            <div class="vr"></div>
                            <div class="w-100 text-center">Timeliness: </div>
                        </div>
                        <hr>

                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">5:</h5>
                                <input type="text" class="form-control" wire:model="eff_5">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">5:</h5>
                                <input type="text" class="form-control" wire:model="qua_5">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">5:</h5>
                                <input type="text" class="form-control" wire:model="time_5">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">4:</h5>
                                <input type="text" class="form-control" wire:model="eff_4">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">4:</h5>
                                <input type="text" class="form-control" wire:model="qua_4">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">4:</h5>
                                <input type="text" class="form-control" wire:model="time_4">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">3:</h5>
                                <input type="text" class="form-control" wire:model="eff_3">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">3:</h5>
                                <input type="text" class="form-control" wire:model="qua_3">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">3:</h5>
                                <input type="text" class="form-control" wire:model="time_3">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">2:</h5>
                                <input type="text" class="form-control" wire:model="eff_2">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">2:</h5>
                                <input type="text" class="form-control" wire:model="qua_2">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">2:</h5>
                                <input type="text" class="form-control" wire:model="time_2">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around gap-2">
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">1:</h5>
                                <input type="text" class="form-control" wire:model="eff_1">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">1:</h5>
                                <input type="text" class="form-control" wire:model="qua_1">
                            </div>
                            <div class="vr"></div>
                            <div class="hstack gap-4 w-100">
                                <h5 class="my-auto">1:</h5>
                                <input type="text" class="form-control" wire:model="time_1">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (isset($users1) && isset($users2))
        {{-- Submit IPCR/Standard/OPCR Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="SubmitISOModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Save IPCR</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="submitISO">
                        <div class="modal-body">
                            <label>Head/Leader/Superior 1: </label>
                            <div class="form-group">
                                <select placeholder="Head/Leader/Superior 1" class="form-control"
                                    wire:model="superior1_id" wire:change="changeUser">
                                    <option value="">Select First Head/Leader/Superior</option>
                                    @foreach ($users1 as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('superior1_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Head/Leader/Superior 2: </label>
                            <div class="form-group">
                                <select placeholder="Head/Leader/Superior 2" class="form-control"
                                    wire:model="superior2_id" wire:change="changeUser">
                                    <option value="">Select Second Head/Leader/Superior</option>
                                    @foreach ($users2 as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('superior2_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Assess IPCR/Standard/OPCR Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AssessISOModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Save IPCR</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="assessISO">
                        @error('quality')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <div class="modal-body">
                            <label>Head/Leader/Superior 1: </label>
                            <div class="form-group">
                                <select placeholder="Head/Leader/Superior 1" class="form-control"
                                    wire:model="superior1_id" wire:change="changeUser">
                                    <option value="">Select First Head/Leader/Superior</option>
                                    @foreach ($users1 as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('superior1_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Head/Leader/Superior 2: </label>
                            <div class="form-group">
                                <select placeholder="Head/Leader/Superior 2" class="form-control"
                                    wire:model="superior2_id" wire:change="changeUser">
                                    <option value="">Select Second Head/Leader/Superior</option>
                                    @foreach ($users2 as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('superior2_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (isset($users))
        {{-- Add TTMA Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddTTMAModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add Assignment</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <label>Subject: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Subject" class="form-control"
                                    wire:model="subject">
                                @error('subject')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Action Officer: </label>
                            <div class="form-group">
                                <select type="text" placeholder="Action Officer" class="form-control"
                                    wire:model="user_id">
                                    <option value="">Select Action Officer</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Output: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Output" class="form-control" wire:model="output">
                                @error('output')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit TTMA Modal --}}
        <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditTTMAModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Assignment</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <label>Subject: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Subject" class="form-control"
                                    wire:model="subject">
                                @error('subject')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Action Officer: </label>
                            <div class="form-group">
                                <select type="text" placeholder="Action Officer" class="form-control"
                                    wire:model="user_id">
                                    <option value="">Select Action Officer</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Output: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Output" class="form-control" wire:model="output">
                                @error('output')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Done Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="DoneModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Done</h4>
                </div>
                <form wire:submit.prevent="done">
                    <div class="modal-body">
                        <p>Mark Assignment as Done?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Done</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Office Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddOfficeModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Office</h4>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <label>Office: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Office" class="form-control" wire:model="office">
                            @error('office')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <label>Building: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Building" class="form-control" wire:model="building">
                            @error('building')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Office Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditOfficeModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Office</h4>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <label>Office: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Office" class="form-control" wire:model="office">
                            @error('office')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <label>Building: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Building" class="form-control" wire:model="building">
                            @error('building')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Account Type Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddAccountTypeModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Account Type</h4>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <label>Account Type: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Account Type" class="form-control"
                                wire:model="account_type">
                                @error('account_type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <label>Rank (1 is highest): </label>
                        <div class="form-group">
                            <input type="text" placeholder="Rank" class="form-control"
                                wire:model="rank">
                                @error('rank')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Account Type Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditAccountTypeModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Account Type</h4>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <label>Account Type: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Account Type" class="form-control"
                                wire:model="account_type">
                                @error('account_type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <label>Rank (1 is highest): </label>
                        <div class="form-group">
                            <input type="text" placeholder="Rank" class="form-control"
                                wire:model="rank">
                                @error('rank')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Duration Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddDurationModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Duration</h4>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <h5>IMPORT NOTICE!<br />You can't add, edit or delete semester duration if already started.</h5>


                        <label>Start Date: </label>
                        <div class="form-group">
                            <input type="date" placeholder="Start Date" class="form-control"
                                wire:change="startChanged" wire:model="start_date" min="{{ date('Y-m-d') }}">
                                @error('start_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>

                        <label>End Date: </label>
                        <div class="form-group">
                            <input type="date" placeholder="End Date" class="form-control"
                                wire:model="end_date"
                                @if (isset($startDate)) min="{{ $startDate }}"
                                @else
                                    min="{{ date('Y-m-d') }}" @endif>
                                @error('end_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Duration Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditDurationModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Duration</h4>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <h5>IMPORT NOTICE!<br />You can't add, edit or delete semester duration if already started.</h5>


                        <label>Start Date: </label>
                        <div class="form-group">
                            <input type="date" placeholder="Start Date" class="form-control"
                                wire:model="start_date" min="{{ date('Y-m-d') }}">
                                @error('start_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>

                        <label>End Date: </label>
                        <div class="form-group">
                            <input type="date" placeholder="End Date" class="form-control"
                                wire:model="end_date" min="{{ date('Y-m-d') }}">
                                @error('end_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reset IPCR Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="ResetIPCRModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Reset IPR</h4>
                </div>
                <form wire:submit.prevent="resetIPCR">
                    <div class="modal-body">
                        <p>You sure you want to reset IPCR?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-danger ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Percentage Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddPercentageModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Percentage</h4>
                </div>
                <form wire:submit.prevent="savePercent">
                    <div class="modal-body">
                        <label>Core Function %: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Core Function" class="form-control"
                                wire:model="core">
                                @error('core')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        @if (isset($subFuncts))
                            <div class="d-flex gap-3" style="height: 100%;">
                                <div class="vr"></div>
                                
                                <div class="">
                                    @foreach ($subFuncts as $sub_funct)
                                        @if ($sub_funct->funct_id == 1)
                                            <label>{{ $sub_funct->sub_funct }} %: </label>
                                            <div class="form-group">
                                                <input type="text" placeholder="{{ $sub_funct->sub_funct }}" class="form-control"
                                                    wire:model="supp.{{ $sub_funct->id }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <label>Strategic Function %: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Strategic Function" class="form-control"
                                wire:model="strategic">
                                @error('strategic')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        @if (isset($subFuncts))
                            <div class="d-flex gap-3" style="height: 100%;">
                                <div class="vr"></div>
                                
                                <div class="">
                                    @foreach ($subFuncts as $sub_funct)
                                        @if ($sub_funct->funct_id == 2)
                                            <label>{{ $sub_funct->sub_funct }} %: </label>
                                            <div class="form-group">
                                                <input type="text" placeholder="{{ $sub_funct->sub_funct }}" class="form-control"
                                                    wire:model="supp.{{ $sub_funct->id }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <label>Support Function %: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Support Function" class="form-control"
                                wire:model="support">
                                @error('support')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        @if (isset($subFuncts))
                            <div class="d-flex gap-3" style="height: 100%;">
                                <div class="vr"></div>
                                
                                <div class="">
                                    @foreach ($subFuncts as $sub_funct)
                                        @if ($sub_funct->funct_id == 3)
                                            <label>{{ $sub_funct->sub_funct }} %: </label>
                                            <div class="form-group">
                                                <input type="text" placeholder="{{ $sub_funct->sub_funct }}" class="form-control"
                                                    wire:model="supp.{{ $sub_funct->id }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Percentage Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditPercentageModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Percentage</h4>
                </div>
                <form wire:submit.prevent="updatePercent">
                    <div class="modal-body">
                        <label>Core Function %: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Core Function" class="form-control"
                                wire:model="core">
                                @error('core')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        @if (isset($subFuncts))
                            <div class="d-flex gap-3" style="height: 100%;">
                                <div class="vr"></div>
                                
                                <div class="">
                                    @foreach ($subFuncts as $sub_funct)
                                        @if ($sub_funct->funct_id == 1)
                                            <label>{{ $sub_funct->sub_funct }} %: </label>
                                            <div class="form-group">
                                                <input type="text" placeholder="{{ $sub_funct->sub_funct }}" class="form-control"
                                                    wire:model="supp.{{ $sub_funct->id }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <label>Strategic Function %: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Strategic Function" class="form-control"
                                wire:model="strategic">
                                @error('strategic')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        @if (isset($subFuncts))
                            <div class="d-flex gap-3" style="height: 100%;">
                                <div class="vr"></div>
                                
                                <div class="">
                                    @foreach ($subFuncts as $sub_funct)
                                        @if ($sub_funct->funct_id == 2)
                                            <label>{{ $sub_funct->sub_funct }} %: </label>
                                            <div class="form-group">
                                                <input type="text" placeholder="{{ $sub_funct->sub_funct }}" class="form-control"
                                                    wire:model="supp.{{ $sub_funct->id }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <label>Support Function %: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Support Function" class="form-control"
                                wire:model="support">
                                @error('support')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        @if (isset($subFuncts))
                            <div class="d-flex gap-3" style="height: 100%;">
                                <div class="vr"></div>
                                
                                <div class="">
                                    @foreach ($subFuncts as $sub_funct)
                                        @if ($sub_funct->funct_id == 3)
                                            <label>{{ $sub_funct->sub_funct }} %: </label>
                                            <div class="form-group">
                                                <input type="text" placeholder="{{ $sub_funct->sub_funct }}" class="form-control"
                                                    wire:model="supp.{{ $sub_funct->id }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-target="#DeletePercentageModal" data-bs-toggle="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Delete</span>
                        </button>
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Percentage Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="DeletePercentageModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Delete Modal</h4>
                </div>
                <form wire:submit.prevent="deletePercentage">
                    <div class="modal-body">
                        <p>You sure you want to delete?</p>
                        <p>Can't recover data once you delete it!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-danger ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Delete</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Disapprove Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="DisapproveModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Disapproving Message</h4>
                </div>
                <form wire:submit.prevent="disapproved">
                    <div class="modal-body">
                        <label>Comment: </label>
                        <div class="form-group">
                            <textarea placeholder="Comment" class="form-control"
                                wire:model="comment">
                            </textarea>
                            @error('comment')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MessageTTMA Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="MessageTTMAModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Done Message</h4>
                </div>
                <form wire:submit.prevent="message">
                    <div class="modal-body">
                        <label>Message: </label>
                        <div class="form-group">
                            <textarea placeholder="Message" class="form-control"
                                wire:model="message">
                            </textarea>
                            @error('message')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EditMessageTTMA Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditMessageTTMAModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Done Message</h4>
                </div>
                <form wire:submit.prevent="message">
                    <div class="modal-body">
                        <label>Message: </label>
                        <div class="form-group">
                            <textarea placeholder="Message" class="form-control"
                                wire:model="message">
                            </textarea>
                            @error('message')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Training Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="AddTrainingModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Training</h4>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <label>Training Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Training Name" class="form-control"
                            wire:model="training">
                            @error('training')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <label>Links: </label>
                        <div class="form-group">
                            <textarea placeholder="Links" class="form-control"
                                wire:model="link">
                            </textarea>
                            @error('link')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <label>Possible Tragets (Seperate with ,): </label>
                        <div class="form-group">
                            <textarea placeholder="Possible Tragets" class="form-control"
                                wire:model="possible_target">
                            </textarea>
                            @error('possible_target')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Training Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditTrainingModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Update Training</h4>
                </div>
                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <label>Training Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Training Name" class="form-control"
                            wire:model="training">
                            @error('training')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <label>Links: </label>
                        <div class="form-group">
                            <textarea placeholder="Links" class="form-control"
                                wire:model="link">
                            </textarea>
                            @error('link')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <label>Possible Tragets (Seperate with ,): </label>
                        <div class="form-group">
                            <textarea placeholder="Possible Tragets" class="form-control"
                                wire:model="possible_target">
                            </textarea>
                            @error('possible_target')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Score Equivalent Modal --}}
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade text-left" id="EditScoreEqModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Update Score Equivalent</h4>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="d-flex justify-content-around gap-2">
                            <div class="w-100 text-center">Equivalent: </div>
                            <div class="vr"></div>
                            <div class="w-100 text-center">Score From: </div>
                            <div class="vr"></div>
                            <div class="w-100 text-center">Score To: </div>
                        </div>
                        <hr>

                        <div class="d-flex justify-content-around gap-2">
                            <div class="gap-4 w-100">
                                <div class="fs-5">Outstanding: </div>
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="out_from">
                                @error('out_from')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="out_to">
                                @error('out_to')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-around gap-2">
                            <div class="gap-4 w-100">
                                <div class="fs-5">Very Satsifactory: </div>
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="verysat_from">
                                @error('verysat_from')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="verysat_to">
                                @error('verysat_to')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-around gap-2">
                            <div class="gap-4 w-100">
                                <div class="fs-5">Satisfactory: </div>
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="sat_from">
                                @error('sat_from')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="sat_to">
                                @error('sat_to')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-around gap-2">
                            <div class="gap-4 w-100">
                                <div class="fs-5">Unatisfactory: </div>
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="unsat_from">
                                @error('unsat_from')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="unsat_to">
                                @error('unsat_to')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-around gap-2">
                            <div class="gap-4 w-100">
                                <div class="fs-5">Poor: </div>
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="poor_from">
                                @error('poor_from')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="vr"></div>
                            <div class="gap-4 w-100 form-group">
                                <input type="text" class="form-control" wire:model="poor_to">
                                @error('poor_to')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
