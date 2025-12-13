<div class="card mb-3">
    <div class="card-header border-0 px-4 py-2">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">@lang('wncms::word.move')</span>
        </h3>
    </div>
    <div class="card-body px-4 py-2">
        <style>
            /* Rotate the arrow up-left */
            .wn-fa-left-up {
                transform: rotate(-45deg);
            }

            /* Rotate the arrow up */
            .wn-fa-up {
                transform: rotate(0deg);
            }

            /* Rotate the arrow up-right */
            .wn-fa-right-up {
                transform: rotate(45deg);
            }

            /* Rotate the arrow left */
            .wn-fa-left {
                transform: rotate(-90deg);
            }

            /* Rotate the checkmark (no rotation needed) */
            .fa-circle-check {
                transform: rotate(0deg);
            }

            /* Rotate the arrow right */
            .wn-fa-right {
                transform: rotate(90deg);
            }

            /* Rotate the arrow down-left */
            .wn-fa-left-down {
                transform: rotate(225deg);
            }

            /* Rotate the arrow down */
            .wn-fa-down {
                transform: rotate(180deg);
            }

            /* Rotate the arrow down-right */
            .wn-fa-right-down {
                transform: rotate(135deg);
            }

            .btn-move,
            .btn-confirm {
                aspect-ratio: 2/1;
                padding: 0 !important;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: rgb(179, 179, 179);
                font-size: 20px;
                width: 100%;
                height: 100%;
            }

            .btn-move i {
                color: white;
            }
        </style>
        <div class="row m-0 w-100">
            <div class="col-4 p-1">
                <button class="btn btn-info btn-move" data-direction="up-left"><i class="fa-solid fa-arrow-up wn-fa-left-up"></i></button>
            </div>
            <div class="col-4 p-1">
                <button class="btn btn-info btn-move" data-direction="up"><i class="fa-solid fa-arrow-up wn-fa-up"></i></button>
            </div>
            <div class="col-4 p-1">
                <button class="btn btn-info btn-move" data-direction="up-right"><i class="fa-solid fa-arrow-up wn-fa-right-up"></i></button>
            </div>
            <div class="col-4 p-1">
                <button class="btn btn-info btn-move" data-direction="left"><i class="fa-solid fa-arrow-up wn-fa-left"></i></button>
            </div>
            <div class="col-4 p-1">
                <button class="btn btn-success btn-confirm"><i class="fa-solid fa-circle-check"></i></button>
            </div>
            <div class="col-4 p-1">
                <button class="btn btn-info btn-move" data-direction="right"><i class="fa-solid fa-arrow-up wn-fa-right"></i></button>
            </div>
            <div class="col-4 p-1">
                <button class="btn btn-info btn-move" data-direction="down-left"><i class="fa-solid fa-arrow-up wn-fa-left-down"></i></button>
            </div>
            <div class="col-4 p-1">
                <button class="btn btn-info btn-move" data-direction="down"><i class="fa-solid fa-arrow-up wn-fa-down"></i></button>
            </div>
            <div class="col-4 p-1">
                <button class="btn btn-info btn-move" data-direction="down-right"><i class="fa-solid fa-arrow-up wn-fa-right-down"></i></button>
            </div>
        </div>
    </div>
</div>