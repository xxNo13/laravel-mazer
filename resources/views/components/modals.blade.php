<div>
    @if (isset($selected) && isset($ost))
        {{-- Configure Output/Suboutput/Target Modal --}}
        <div wire:ignore.self class="modal fade text-left" id="ConfigureIPCROSTModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add Output/Suboutput/Target</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="form-group d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="add"
                                        value="add" name="ost" wire:model="ost">
                                    <label class="form-check-label" for="add">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="edit"
                                        value="edit" name="ost" wire:model="ost">
                                    <label class="form-check-label" for="edit">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="target"
                                        value="delete" name="ost" wire:model="ost">
                                    <label class="form-check-label" for="target">
                                        Delete
                                    </label>
                                </div>
                            </div>

                            <hr>

                            <div class="mt-3 form-group d-flex justify-content-between">
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
                            <div wire:loading class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <div class="mt-3">
                                @if ($selected == 'output' && $ost == 'add')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Output" class="form-control" name="output"
                                            wire:model="output">
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'output' && $ost == 'edit')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <select placeholder="Output" class="form-control" wire:model="output_id"
                                            wire:change="editChanged">
                                            <option value="">Select an output</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @if ($output->type == 'ipcr')
                                                    <option value="{{ $output->id }}">{{ $output->code }}
                                                        {{ $output->output }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <label>Output: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Output" class="form-control"
                                            name="output" wire:model="output">
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'output' && $ost == 'delete')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <select placeholder="Output" class="form-control" wire:model="output_id">
                                            <option value="">Select an output</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @if ($output->type == 'ipcr')
                                                    <option value="{{ $output->id }}">{{ $output->code }}
                                                        {{ $output->output }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'suboutput' && $ost == 'add')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <select placeholder="Output" class="form-control" wire:model="output_id">
                                            <option value="">Select an output</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @forelse ($output->targets as $target)
                                                @empty
                                                    @if ($output->type == 'ipcr')
                                                        <option value="{{ $output->id }}">{{ $output->code }}
                                                            {{ $output->output }}
                                                        </option>
                                                    @endif
                                                @endforelse
                                            @endforeach
                                        </select>
                                        @error('output')
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
                                @elseif ($selected == 'suboutput' && $ost == 'edit')
                                    <label>Suboutput: </label>
                                    <div class="form-group">
                                        <select placeholder="Suboutput" class="form-control"
                                            wire:model="suboutput_id" wire:change="editChanged">
                                            <option value="">Select a suboutput</option>
                                            @foreach (Auth::user()->suboutputs as $suboutput)
                                                @if ($suboutput->type == 'ipcr')
                                                    <option value="{{ $suboutput->id }}">{{ $suboutput->output->code }}
                                                        {{ $suboutput->output->output }} - {{ $suboutput->suboutput }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('suboutput')
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
                                @elseif ($selected == 'suboutput' && $ost == 'delete')
                                    <label>Suboutput: </label>
                                    <div class="form-group">
                                        <select placeholder="Suboutput" class="form-control"
                                            wire:model="suboutput_id">
                                            <option value="">Select a suboutput</option>
                                            @foreach (Auth::user()->suboutputs as $suboutput)
                                                @if ($suboutput->type == 'ipcr')
                                                    <option value="{{ $suboutput->id }}">{{ $suboutput->output->code }}
                                                        {{ $suboutput->output->output }} - {{ $suboutput->suboutput }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('suboutput')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'target' && $ost == 'add')
                                    <label>Output/Suboutput: </label>
                                    <div class="form-group">
                                        <select placeholder="Output/Suboutput" class="form-control"
                                            wire:model="subput">
                                            <option value="">Select an/a output/suboutput</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @forelse ($output->suboutputs as $suboutput)
                                                @empty
                                                    @if ($output->type == 'ipcr')
                                                        <option value="output, {{ $output->id }}">{{ $output->code }}
                                                            {{ $output->output }}
                                                        </option>
                                                    @endif
                                                @endforelse
                                            @endforeach
                                            @foreach (Auth::user()->suboutputs as $suboutput)
                                                @if ($suboutput->type == 'ipcr')
                                                    <option value="suboutput, {{ $suboutput->id }}">
                                                        {{ $suboutput->output->code }} {{ $suboutput->output->output }} -
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
                                @elseif ($selected == 'target' && $ost == 'edit')
                                    <label>Target: </label>
                                    <div class="form-group">
                                        <select placeholder="Target" class="form-control" wire:model="target_id"
                                            wire:change="editChanged">
                                            <option value="">Select a Target</option>
                                            @foreach (Auth::user()->targets as $target)
                                                @if ($target->type == 'ipcr')
                                                    <option value="{{ $target->id }}">
                                                        @if ($target->output)
                                                            {{ $target->output->code }} {{ $target->output->output }} -
                                                        @elseif ($target->suboutput)
                                                            {{ $target->suboutput->output->code }}
                                                            {{ $target->suboutput->output->output }} -
                                                            {{ $target->suboutput->suboutput }} -
                                                        @endif
                                                        {{ $target->target }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('target')
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
                                @elseif ($selected == 'target' && $ost == 'delete')
                                    <label>Target: </label>
                                    <div class="form-group">
                                        <select placeholder="Target" class="form-control" wire:model="target_id">
                                            <option value="">Select a target</option>
                                            @foreach (Auth::user()->targets as $target)
                                                @if ($target->type == 'ipcr')
                                                    <option value="{{ $target->id }}">
                                                        @if ($target->output)
                                                            {{ $target->output->code }} {{ $target->output->output }} -
                                                        @elseif ($target->suboutput)
                                                            {{ $target->suboutput->output->code }}
                                                            {{ $target->suboutput->output->output }} -
                                                            {{ $target->suboutput->suboutput }} -
                                                        @endif
                                                        {{ $target->target }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
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
                            @if ($ost == 'add')
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            @elseif ($ost == 'edit')
                                <button type="submit" class="btn btn-success ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Update</span>
                                </button>
                            @elseif ($ost == 'delete')
                                <button type="button" class="btn btn-danger ml-1" data-bs-target="#DeleteModal"
                                    data-bs-toggle="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Delete</span>
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Configure Output/Suboutput/Target Modal --}}
        <div wire:ignore.self class="modal fade text-left" id="ConfigureOPCROSTModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add Output/Suboutput/Target</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="form-group d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="add"
                                        value="add" name="ost" wire:model="ost">
                                    <label class="form-check-label" for="add">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="edit"
                                        value="edit" name="ost" wire:model="ost">
                                    <label class="form-check-label" for="edit">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:change="changed" type="radio" class="form-check-input" id="target"
                                        value="delete" name="ost" wire:model="ost">
                                    <label class="form-check-label" for="target">
                                        Delete
                                    </label>
                                </div>
                            </div>

                            <hr>

                            <div class="mt-3 form-group d-flex justify-content-between">
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
                            <div wire:loading class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <div class="mt-3">
                                @if ($selected == 'output' && $ost == 'add')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Output" class="form-control" name="output"
                                            wire:model="output">
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'output' && $ost == 'edit')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <select placeholder="Output" class="form-control" wire:model="output_id"
                                            wire:change="editChanged">
                                            <option value="">Select an output</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @if ($output->type == 'opcr')
                                                    <option value="{{ $output->id }}">{{ $output->code }}
                                                        {{ $output->output }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <label>Output: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Output" class="form-control"
                                            name="output" wire:model="output">
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'output' && $ost == 'delete')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <select placeholder="Output" class="form-control" wire:model="output_id">
                                            <option value="">Select an output</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @if ($output->type == 'opcr')
                                                    <option value="{{ $output->id }}">{{ $output->code }}
                                                        {{ $output->output }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('output')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'suboutput' && $ost == 'add')
                                    <label>Output: </label>
                                    <div class="form-group">
                                        <select placeholder="Output" class="form-control" wire:model="output_id">
                                            <option value="">Select an output</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @forelse ($output->targets as $target)
                                                @empty
                                                    @if ($output->type == 'opcr')
                                                        <option value="{{ $output->id }}">{{ $output->code }}
                                                            {{ $output->output }}
                                                        </option>
                                                    @endif
                                                @endforelse
                                            @endforeach
                                        </select>
                                        @error('output')
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
                                @elseif ($selected == 'suboutput' && $ost == 'edit')
                                    <label>Suboutput: </label>
                                    <div class="form-group">
                                        <select placeholder="Suboutput" class="form-control"
                                            wire:model="suboutput_id" wire:change="editChanged">
                                            <option value="">Select a suboutput</option>
                                            @foreach (Auth::user()->suboutputs as $suboutput)
                                                @if ($suboutput->type == 'opcr')
                                                    <option value="{{ $suboutput->id }}">{{ $suboutput->output->code }}
                                                        {{ $suboutput->output->output }} - {{ $suboutput->suboutput }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('suboutput')
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
                                @elseif ($selected == 'suboutput' && $ost == 'delete')
                                    <label>Suboutput: </label>
                                    <div class="form-group">
                                        <select placeholder="Suboutput" class="form-control"
                                            wire:model="suboutput_id">
                                            <option value="">Select a suboutput</option>
                                            @foreach (Auth::user()->suboutputs as $suboutput)
                                                @if ($suboutput->type == 'opcr')
                                                    <option value="{{ $suboutput->id }}">{{ $suboutput->output->code }}
                                                        {{ $suboutput->output->output }} - {{ $suboutput->suboutput }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('suboutput')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif ($selected == 'target' && $ost == 'add')
                                    <label>Output/Suboutput: </label>
                                    <div class="form-group">
                                        <select placeholder="Output/Suboutput" class="form-control"
                                            wire:model="subput">
                                            <option value="">Select an/a output/suboutput</option>
                                            @foreach (Auth::user()->outputs as $output)
                                                @forelse ($output->suboutputs as $suboutput)
                                                @empty
                                                    @if ($output->type == 'opcr')
                                                        <option value="output, {{ $output->id }}">{{ $output->code }}
                                                            {{ $output->output }}
                                                        </option>
                                                    @endif
                                                @endforelse
                                            @endforeach
                                            @foreach (Auth::user()->suboutputs as $suboutput)
                                                @if ($suboutput->type == 'opcr')
                                                    <option value="suboutput, {{ $suboutput->id }}">
                                                        {{ $suboutput->output->code }} {{ $suboutput->output->output }} -
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
                                @elseif ($selected == 'target' && $ost == 'edit')
                                    <label>Target: </label>
                                    <div class="form-group">
                                        <select placeholder="Target" class="form-control" wire:model="target_id"
                                            wire:change="editChanged">
                                            <option value="">Select a Target</option>
                                            @foreach (Auth::user()->targets as $target)
                                                @if ($target->type == 'opcr')
                                                    <option value="{{ $target->id }}">
                                                        @if ($target->output)
                                                            {{ $target->output->code }} {{ $target->output->output }} -
                                                        @elseif ($target->suboutput)
                                                            {{ $target->suboutput->output->code }}
                                                            {{ $target->suboutput->output->output }} -
                                                            {{ $target->suboutput->suboutput }} -
                                                        @endif
                                                        {{ $target->target }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('target')
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
                                @elseif ($selected == 'target' && $ost == 'delete')
                                    <label>Target: </label>
                                    <div class="form-group">
                                        <select placeholder="Target" class="form-control" wire:model="target_id">
                                            <option value="">Select a target</option>
                                            @foreach (Auth::user()->targets as $target)
                                                @if ($target->type == 'opcr')
                                                    <option value="{{ $target->id }}">
                                                        @if ($target->output)
                                                            {{ $target->output->code }} {{ $target->output->output }} -
                                                        @elseif ($target->suboutput)
                                                            {{ $target->suboutput->output->code }}
                                                            {{ $target->suboutput->output->output }} -
                                                            {{ $target->suboutput->suboutput }} -
                                                        @endif
                                                        {{ $target->target }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
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
                            @if ($ost == 'add')
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            @elseif ($ost == 'edit')
                                <button type="submit" class="btn btn-success ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Update</span>
                                </button>
                            @elseif ($ost == 'delete')
                                <button type="button" class="btn btn-danger ml-1" data-bs-target="#DeleteModal"
                                    data-bs-toggle="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Delete</span>
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    <div wire:ignore.self class="modal fade text-left" id="DeleteModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Delete Modal</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
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
                        <button type="submit" class="btn btn-danger ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Delete</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Rating Modal --}}
    <div wire:ignore.self class="modal fade text-left" id="AddRatingModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Rating</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div wire:loading class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
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
                            <input type="text" placeholder="Quality" class="form-control" wire:model="quality">
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
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Rating Modal --}}
    <div wire:ignore.self class="modal fade text-left" id="EditRatingModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Rating</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div wire:loading class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <form wire:submit.prevent="saveRating('{{ 'edit' }}')">
                    <div class="modal-body">
                        <label>Actual Accomplishment: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Actual Accomplishment" class="form-control"
                                wire:model="accomplishment">
                        </div>
                        <label>Efficiency: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Efficiency" class="form-control"
                                wire:model="efficiency">
                        </div>
                        <label>Quality: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Quality" class="form-control" wire:model="quality">
                        </div>
                        <label>Timeliness: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Timeliness" class="form-control"
                                wire:model="timeliness">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-success ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Standard Modal --}}
    <div wire:ignore.self class="modal fade text-left" id="AddStandardModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Standard</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
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
                        <div wire:loading class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

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
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Standard Modal --}}
    <div wire:ignore.self class="modal fade text-left" id="EditStandardModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Standard</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
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
                        <div wire:loading class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

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
                        <button type="submit" class="btn btn-success ml-1">
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
        <div wire:ignore.self class="modal fade text-left" id="SubmitISOModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Save IPCR</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div wire:loading class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1">
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
        <div wire:ignore.self class="modal fade text-left" id="AddTTMAModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add Assignment</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div wire:loading class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <label>Subject: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Subject" class="form-control"
                                    wire:model="subject">
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
                            </div>
                            <label>Output: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Output" class="form-control" wire:model="output">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit TTMA Modal --}}
        <div wire:ignore.self class="modal fade text-left" id="EditTTMAModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Assignment</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div wire:loading class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <label>Subject: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Subject" class="form-control"
                                    wire:model="subject">
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
                            </div>
                            <label>Output: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Output" class="form-control" wire:model="output">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-success ml-1">
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
    <div wire:ignore.self class="modal fade text-left" id="DoneModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Done</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
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
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Done</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
