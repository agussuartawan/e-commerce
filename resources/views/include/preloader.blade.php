<style>
    #preloader {
        position: absolute;
        /* Sit on top of the page content */
        display: none;
        /* Hidden by default */
        width: 100%;
        /* Full width (cover the whole page) */
        height: auto;
        /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.685);
        /* Black background with opacity */
        z-index: 20;
        /* Specify a stack order in case you're using a different order for other elements */
    }

</style>
<div id="preloader">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('') }}/loading-gif/loading1.gif">
            </div>
        </div>
    </div>
</div>
