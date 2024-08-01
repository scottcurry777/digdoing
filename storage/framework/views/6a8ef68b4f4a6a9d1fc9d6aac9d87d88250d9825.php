<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    
    <div style="
        flex: 1 1 100%;
        width: 100%;
        margin-bottom: -10px;
        display: flex;
        flex-direction: row;
        align-items: stretch;
        justify-content: center;
    ">
        <div style="
            flex: 1 1 170px;
            margin: 10px;
            display: flex;
            flex-flow: column wrap;
        ">
            <div id="button-view-logs" data-href="https://digdoing.com/admin/logs" class="button button-blue">View Logs</div>
        </div>
        
        <div class="admin-content" style="
            flex: 1 1 100%;
            display: flex;
        ">
            <iframe id="admin-content" src="https://digdoing.com/admin/logs" frameBorder="0" style="flex: 1 1 100%;"></iframe>
        </div>
    </div>
    
    <script>
        $("#button-view-logs").click(function () { 
            $("#admin-content").attr("src", $(this).data('href'));
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/admin/index.blade.php ENDPATH**/ ?>