<div class="modal fade" id="modal_trans_pet" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal-title-trans_pet">Add Pet</h4>
            </div>

            <form id="petsave" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control input-sm" id="m_oidpet" name="m_oidpet">
                    <input type="hidden" class="form-control input-sm" id="m_pid" name="m_pid">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group-input">
                                <div class="form-group">
                                    <label for="m_fpetname">Pet Name <span class="required"> *</span></label>
                                    <input type="text" class="form-control input-sm" id="m_fpetname" name="m_fpetname" placeholder="start typing here...">
                                </div>

                                <div class="form-group">
                                    <label for="m_fpetbday">Birth Date <span class="required"> *</span></label>
                                    <input type="text" class="form-control input-sm" id="m_fpetbday" name="m_fpetbday" placeholder="start typing here...">
                                </div>
                                <div class="form-group">
                                    <label for="m_fpetspecies">Species <span class="required"> *</span></label>
                                    <select class="form-control input-sm" id="m_fpetspecies" name="m_fpetspecies"></select>
                                </div>

                                <div class="form-group">
                                    <label for="m_fpetbreed">Breed <span class="required"> *</span></label>
                                    <select class="form-control input-sm" id="m_fpetbreed" name="m_fpetbreed"></select>
                                </div>
                                <div class="form-group">
                                    <label for="m_fpetgender">Gender <span class="required"> *</span></label>
                                    <select class="form-control input-sm" id="m_fpetgender" name="m_fpetgender">
                                        <option value="">Select...</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="text-right">
                                    <button type="button" class="btn btn-primary btn-sm" id="m_pet_add"><i class="fa fa-save"></i> Save Changes</button>
                                    <button type="button" class="btn btn-warning btn-sm" id="m_pet_cancel"><i class="fa fa-times"></i> Cancel</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group-table">
                                <table class="table table-striped table-hovered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Birthdate</th>
                                            <th>Species</th>
                                            <th>Breed</th>
                                            <th>Gender</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="m_pet_tbody_details">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>