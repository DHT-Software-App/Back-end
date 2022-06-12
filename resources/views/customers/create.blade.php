<div id="form-errors"></div>

    <form method="post" id="formrols" action="{{ route('customers.store') }}" >
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <strong>First name:</strong>
                    <input type="text" name="first_name" id="first_name" placeholder="First name" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <strong>Last name:</strong>
                    <input type="text" name="last_name" id="last_name" placeholder="Last name" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <strong>Email address:</strong>
                    <input type="text" name="last_name" id="last_name" placeholder="Last name" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <strong>Street:</strong>
                    <input type="text" name="street" id="street" placeholder="Last name" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <strong>State:</strong>
                    <input type="text" name="last_name" id="last_name" placeholder="Last name" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <strong>City:</strong>
                    <input type="text" name="last_name" id="last_name" placeholder="Last name" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <strong>Zip:</strong>
                    <input type="text" name="last_name" id="last_name" placeholder="Last name" class="form-control">
                </div>
            </div>
            <br>
            <div class="col-md-12">
                <!--Begin::Contact-->
                <div class="pt-6">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Add customer-->
                        <center> <a href='javascript:void(0);' class="btn btn-primary customer-contact-add">Add Contact</a><center>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Card toolbar-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="tablecustomerscontact">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Contact</th>
                                    <th class="text-end min-w-70px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600" id="tablecustomerscontactdetails">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Contact-->

                  <!--Begin::Insure-->
                <div class="pt-6">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Add customer-->
                        <center> <a href='javascript:void(0);'  class="btn btn-primary customer-email-add">Add Email</a><center>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Card toolbar-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="tablecustomersemaildetails">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Email</th>
                                    <th class="text-end min-w-70px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Insure-->
            </div>
            <div id="divresultRols"></div>
            <center>  
                <button type="submit"   class="btn btn-success">{{ __("Create")}}</button>
                <a href='javascript:void(0)' data-bs-dismiss="modal" class="btn btn-danger">{{ __("Close")}}</a>
            </center>
        </div>
    </form>