<?= $this->extend('admin/layout/app'); ?>

<?= $this->section('meta_info') ?>
    <title><?= "Search Form | " . APP_NAME ?></title>
    <style>
    .card-img-top {
        width: 100%;         
        height: 200px;       
        object-fit: cover;    
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('head_cdn') ?>
<!-- link cdn/file for header -->
<?= $this->endSection(); ?>

<?= $this->section('content') ?>


<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h3 class="text-center mb-4">Search Images/Videos</h3>
                <form action="<?= base_url('search') ?>" method="POST" id="searchForm">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="query" placeholder="Enter search term..." required>
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search results will be displayed here -->
        <div class="row" id="searchResults">
            <!-- AJAX-loaded content will appear here -->
        </div>
    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->

<?= $this->endSection(); ?>
<?= $this->section('footer_cdn') ?>
<!-- link cdn/file for footer -->

<!-- <script>
    // Submit the form and fetch search results
    $('#searchForm').submit(function(event) {
        event.preventDefault();
        let query = $('input[name="query"]').val();
        let apiKey = "47049519-d67d50a4d135c9c888f151da1";  
        
        $.ajax({
            url: `https://pixabay.com/api/?key=${apiKey}&q=${encodeURIComponent(query)}&image_type=photo&pretty=true`,
            method: "GET",
            success: function(data) {
                let resultsContainer = $('#searchResults');
                resultsContainer.empty();
                if (data.hits && data.hits.length > 0) {
                    data.hits.forEach(item => {
                        resultsContainer.append(`
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="${item.previewURL}" class="card-img-top" alt="${item.tags}">
                                    <div class="card-body">
                                        <h5 class="card-title">${item.tags}</h5>
                                        <a href="${item.largeImageURL}" target="_blank" class="btn btn-primary">View Full Image</a>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    resultsContainer.append('<p class="text-center">No results found.</p>');
                }
            },
            error: function(error) {
                alert('Error fetching data. Please try again.');
            }
        });
    });
</script> -->
<script>
    // Submit the form and fetch search results
    $('#searchForm').submit(function(event) {
        event.preventDefault();
        let query = $('input[name="query"]').val();
        let apiKey = "47049519-d67d50a4d135c9c888f151da1";  
        
        $.ajax({
            url: `https://pixabay.com/api/?key=${apiKey}&q=${encodeURIComponent(query)}&image_type=photo&pretty=true`,
            method: "GET",
            success: function(data) {
                let resultsContainer = $('#searchResults');
                resultsContainer.empty();
                if (data.hits && data.hits.length > 0) {
                    data.hits.forEach(item => {
                        resultsContainer.append(`
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="${item.previewURL}" class="card-img-top" alt="${item.tags}">
                                    <div class="card-body">
                                        <h5 class="card-title">${item.tags}</h5>
                                        <a href="${item.largeImageURL}" target="_blank" class="btn btn-primary">View Full Image</a>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    resultsContainer.append('<p class="text-center">No results found.</p>');
                }
            },
            error: function(error) {
                alert('Error fetching data. Please try again.');
            }
        });
    });
</script>

<?= $this->endSection(); ?>
