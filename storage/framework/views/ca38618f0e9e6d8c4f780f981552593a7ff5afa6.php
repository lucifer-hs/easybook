            
            <?php $__env->startSection('content'); ?>
            <div class="col-sm-8 blog-main">
                <div>
                    <div id="carousel-example" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example" data-slide-to="1"></li>
                            <li data-target="#carousel-example" data-slide-to="2"></li>
                        </ol><!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="http://127.0.0.1/storage/20d0b3e9d373a231726527d18a226bab/R4ZruQNBVeqM1eDYFgyzpJZnAZf1TO43shhNjkcl.jpeg" alt="..." />
                                <div class="carousel-caption">...</div>
                            </div>
                            <div class="item">
                                <img src="http://127.0.0.1/storage/bffd6a15af0c258c43d769d420f5c6d9/7TWDLTpkxEeRBkke52UsAvkSOlgdv8FFOg7kni3Q.jpeg" alt="..." />
                                <div class="carousel-caption">...</div>
                            </div>
                            <div class="item">
                                <img src="http://127.0.0.1/storage/b0fab325f6f8b9560ec503390e83f024/nV0Hq19eR3omD6zf0TY3EvxOSXE2I3qx2bLLgVxJ.jpeg" alt="..." />
                                <div class="carousel-caption">...</div>
                            </div>
                        </div>
                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span></a>
                        <a class="right carousel-control" href="#carousel-example" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                </div>
                <div style="height: 20px;">
                </div>
                <div>
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="blog-post">
                        <h2 class="blog-post-title"><a href="/posts/<?php echo e($post->id); ?>"><?php echo e($post->title); ?></a></h2>
                        <p class="blog-post-meta"><?php echo e($post->created_at->toFormattedDateString()); ?> by<a href="/user/<?php echo e($post->user_id); ?>"><?php echo e($post->user->name); ?></a></p>
                       <?php echo str_limit($post->content,100,"..."); ?>

                            <p class="blog-post-meta">赞 <?php echo e($post->zans_count); ?> | 评论 <?php echo e($post->comments_count); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($posts->links()); ?>

                </div><!-- /.blog-main -->
            </div>
            <?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>