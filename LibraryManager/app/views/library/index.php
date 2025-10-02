<?php include(__DIR__ . '/../header.php'); ?>

<div class="container">
    <h1 class="text-center my-5">Library</h1>

    <!-- Връски с основни раутове -->
    <div class="text-center mb-3">
        <a href="/literaryWork" class="btn btn-primary mx-2">Manage content</a>
        <a href="/libraryUser" class="btn btn-primary mx-2">Manage members</a>
        <a href="/kjdsadhsakdha" class="btn btn-warning mx-2">404 route</a>
    </div>

    <!-- Търсене на произведение -->
    <div class="d-flex justify-content-center mb-5">
        <form class="form-inline d-flex" method="GET" action="/home/search">
            <div class="form-group mx-sm-1 mb-2">
                <input type="text" name="search" class="form-control search-bar" placeholder="Search ISBN, Title, Author...">
            </div>
            <button type="submit" class="btn btn-success mb-2">Search</button>
        </form>
    </div>

    <!-- Редване на хтмл-а само ако searchResults е сетнат -->
    <?php if (isset($searchResults)) : ?>
        <div class="container mb-5">
            <h2 class="text-center my-3">Search Results</h2>
            <!-- Удачно съобщение ако literaryWorks е празен -->
            <?php if (empty($searchResults)) : ?>
                <p class="text-center text-danger">No results found</p>
            <?php endif; ?>

            <!-- Принтирам произведения и тяхните специфични (спрямо типа) данни -->
            <ul class="list-group">
                <?php foreach ($searchResults as $result) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <h5><?php echo htmlspecialchars($result['work']->getTitle()); ?></h5>
                            <p>Author: <?php echo htmlspecialchars($result['work']->getAuthor()); ?></p>
                            <p>ISBN: <?php echo htmlspecialchars($result['work']->getISBN()); ?></p>
                            <?php if ($result['type'] === 'Book') : ?>
                                <p>Genre: <?php echo htmlspecialchars($result['genre']); ?></p>
                                <p>Stock: <?php echo htmlspecialchars($result['stock']); ?></p>
                            <?php elseif ($result['type'] === 'Magazine') : ?>
                                <p>Issue Date: <?php echo htmlspecialchars($result['issueDate']); ?></p>
                            <?php elseif ($result['type'] === 'Newspaper') : ?>
                                <p>Is Free: <?php echo htmlspecialchars($result['isFree'] ? 'Yes' : 'No'); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php
                        //Задавам икона спрямо типа на произведението
                        if ($result['type'] === 'Book') echo '<i class="fa-solid fa-book"></i>';
                        //Тва реално пак е книга, ама font awesome нямаше безплатна икона за списание
                        elseif ($result['type'] === 'Magazine') echo '<i class="fa-solid fa-book-open"></i>';
                        elseif ($result['type'] === 'Newspaper') echo '<i class="fa-solid fa-newspaper"></i>';
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<?php include(__DIR__ . '/../footer.php'); ?>