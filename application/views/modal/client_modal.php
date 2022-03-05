<div class="modal fade" id="modal_trans" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal-title-trans">Add Client</h4>
            </div>

            <form action="transsave" method="post" id="transsave">
                <div class="modal-body">
                    <input type="hidden" id="m_oid" name="m_oid">
                    <input type="hidden" id="m_page" name="m_page" value="">               

                    <div class="form-group">
                        <label for="m_fname">First Name <span class="required"> *</span></label>
                        <input type="text" class="form-control input-sm" id="m_fname" name="m_fname" placeholder="start typing here..." required="required">
                    </div>
                    <div class="form-group">
                        <label for="m_mname">Middle Name</label>
                        <input type="text" class="form-control input-sm" id="m_mname" name="m_mname" placeholder="start typing here...">
                    </div>
                    <div class="form-group">
                        <label for="m_lname">Last Name <span class="required"> *</span></label>
                        <input type="text" class="form-control input-sm" id="m_lname" name="m_lname" placeholder="start typing here..." required="required">
                    </div>
                    <div class="form-group">
                        <label for="m_address">Address <span class="required"> *</span></label>
                        <input type="text" class="form-control input-sm" id="m_address" name="m_address" placeholder="start typing here..." required="required">
                    </div>
                    <div class="form-group">
                        <label for="m_contactnum">Contact Number <span class="required"> *</span></label>
                        <input type="text" class="form-control input-sm" id="m_contactnum" name="m_contactnum" placeholder="start typing here..." required="required">
                    </div>
                    <div class="form-group">
                        <label for="m_emailadd">Email Address </label>
                        <input type="email" class="form-control input-sm" id="m_emailadd" name="m_emailadd" placeholder="start typing here...">
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm" id="m_client_submit">Save changes</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
