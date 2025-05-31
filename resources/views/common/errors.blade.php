

@if (count($errors) > 0)

<?php // resources/views/common/errors.blade.php ?>

    <!-- Form Error List -->
    <div class="alert alert-danger">
        

        <br><br>

        <ul>
            <li><strong>Whoops! Something went wrong!</strong></li>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif