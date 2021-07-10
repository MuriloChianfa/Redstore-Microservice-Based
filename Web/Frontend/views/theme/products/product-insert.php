<?php $v->layout("theme/_theme"); ?>

<!------------ FEATURED PRODUCTS ------------->

<div class="small-container">

    <div class="row row-2">
        <h2>Product Insert</h2>    
    </div>

    <div class="row">
        <div class="form-message">
            <div class="login_form_callback">
                <?= flash(); ?>
            </div>
        </div>
    </div>

    <form action="<?= $mainURL ?>/product" method="post">
        <div class="row">
            <div class="raw-col-8">
                <h4 class="modal-text noselect">Title</h4>

                <input type="text" class="alter-input" name="name" value="" />
            </div>
        </div>

        <div class="row">
            <div class="raw-col-8">
                <h4 class="modal-text noselect">Description</h4>

                <input type="text" class="alter-input" name="description" value="" />
            </div>
        </div>

        <div class="row">
            <div class="raw-col-8">
                <h4 class="modal-text noselect">Category</h4>

                <select name="category_id" style="margin-top: 24px; width: 100%;">
                    <option value="" selected>Select one category...</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $value): ?>
                            <option value="<?= $value->id ?>"><?= $value->name ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="raw-col-8">
                <h4 class="modal-text noselect">Price per unit</h4>

                <input type="text" class="alter-input" name="value" value="" />
            </div>
        </div>

        <div class="row">
            <div class="raw-col-8">
                <h4 class="modal-text noselect">Quantity</h4>

                <input type="number" class="alter-input" name="avaliable" value="" />
            </div>
        </div>

        <div class="row">
            <div class="raw-col-8">
                <h4 class="modal-text noselect">Images</h4>

                <input type="file" name="name" multiple />
            </div>
        </div>

        <div class="row">
            <div class="raw-col-8">
                <input type="submit" class="btn" value="Submit" />
            </div>
        </div>
    </form>

</div>
