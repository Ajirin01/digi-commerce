<!-- Begin Uren's Modal Area -->
<div class="modal fade modal-wrapper" id="exampleModalCenter{{$shop->id}}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-inner-area sp-area row">
                    <div class="col">
                        <h4>Shop Information</h4>
                        <ul>
                            <li>
                               <b>Name:</b> {{$shop->name}}
                            </li>
                            <li>
                                <b>Phone:</b> <a href="tel:{{$shop->seller->user->phone}}">{{$shop->seller->user->phone}}</a> 
                            </li>
                            <li>
                                <b>Email:</b> {{$shop->seller->user->email}}
                            </li>
                            <li>
                                <b>Product Name:</b> {{$product->name}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- Uren's Modal Area End Here -->