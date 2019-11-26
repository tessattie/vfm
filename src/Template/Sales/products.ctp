<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Réquisitions</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Ventes par Produits
        </div>

    <div class="panel-body articles-container">
    <div class="row">
        <div class="col-m-12">
            <?= $this->Form->create() ?>
                <div class="row">
                    <div class="col-md-4">
                        <?= $this->Form->control('from', array('class' => 'form-control', "label" => "De : ", "type" => "date")); ?>
                    </div>

                    <div class="col-md-4">
                        <?= $this->Form->control('to', array('class' => 'form-control', "label" => "A : ", "type" => "date")); ?>
                    </div>

                    <div class="col-md-1">
                        <?= $this->Form->button(__('Valider'), array('class'=>'btn btn-success', "style"=>"float:left")) ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
            <hr>
        </div>
    </div>
            <table class="table table-stripped datatable">
                <thead> 
                        <th>Produit</th>
                        <th class="text-right">Ventes</th>
                </thead>
            <tbody> 
        <?php foreach ($product_list as $product): ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td class="text-right"><?= number_format($product['total_sold'],2,".", " ") ?> M3</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<style type="text/css">
    select{
        padding: 5px;
        /* margin-right: 5px; */
        margin-left: 5px;
        margin-bottom: 20px;
        }

    .input label{
        margin-left:22px;
    }
</style>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
            "ordering": false
        });
    })
</script>