<?php include(__DIR__ . '/../header.php'); ?>

<!-- Редване на хтмл-а само ако literaryWorks е сетнат -->
<?php if (isset($literaryWorks)) : ?>
    <div class="container mb-5">
        <h2 class="text-center my-3">All content of the library</h2>
        <div class="text-center mb-3">
            <a href="/home" class="btn btn-secondary mx-2">Home</a>
            <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#addItemModal">Add item</button>
        </div>

        <!-- Удачно съобщение ако literaryWorks е празен -->
        <?php if (empty($literaryWorks)) : ?>
            <p class="text-center text-danger">No results found</p>
        <?php endif; ?>

        <!-- Модал от буутстрап -->
        <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addItemModalLabel">Add Item to Library</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="return resetForm(addItemForm)"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="addItemForm" action="/literaryWork/add">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" id="author" name="author" required>
                            </div>
                            <div class="mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Select Type</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="" disabled selected>Select a type</option>
                                    <option value="0">Book</option>
                                    <option value="1">Magazine</option>
                                    <option value="2">Newspaper</option>
                                </select>
                            </div>
                            <div id="additionalInputForSelectedType"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="return resetForm(addItemForm)">Cancel</button>
                                <button type="submit" class="btn btn-success" id="addItemButton">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- За много бейсик евент хандлинг -->
        <script src="/../scripts/literaryWork/index.js"></script>

        <!-- Принтирам произведения и тяхните специфични (спрямо типа) данни -->
        <ul class="list-group">
            <?php foreach ($literaryWorks as $literaryWork) : ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        <h5><?php echo htmlspecialchars($literaryWork['work']->getTitle()); ?></h5>
                        <p>Author: <?php echo htmlspecialchars($literaryWork['work']->getAuthor()); ?></p>
                        <p>ISBN: <?php echo htmlspecialchars($literaryWork['work']->getISBN()); ?></p>
                        <?php if ($literaryWork['type'] === 'Book') : ?>
                            <p>Genre: <?php echo htmlspecialchars($literaryWork['genre']); ?></p>
                            <p>Stock: <?php echo htmlspecialchars($literaryWork['stock']); ?></p>
                        <?php elseif ($literaryWork['type'] === 'Magazine') : ?>
                            <p>Issue Date: <?php echo htmlspecialchars($literaryWork['issueDate']); ?></p>
                        <?php elseif ($literaryWork['type'] === 'Newspaper') : ?>
                            <p>Is Free: <?php echo htmlspecialchars($literaryWork['isFree'] ? 'Yes' : 'No'); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php
                    $faIcon = '';
                    if ($literaryWork['type'] === 'Book') $faIcon = '<i class="fa-solid fa-book"></i>';
                    elseif ($literaryWork['type'] === 'Magazine') $faIcon = '<i class="fa-solid fa-book-open"></i>';
                    elseif ($literaryWork['type'] === 'Newspaper') $faIcon = '<i class="fa-solid fa-newspaper"></i>';
                    ?>

                    <!-- Форма за изтриване на произведения (калва съответния раут, който води до контролера и метода) -->
                    <form class="icon-button-container" method="POST" action="/literaryWork/delete" onsubmit="return confirm('Сигурни ли сте, че искате да зитриете това произведение?')">
                        <?php echo $faIcon; ?>
                        <input type="hidden" name="ISBN" value="<?php echo htmlspecialchars($literaryWork['work']->getISBN()); ?>">
                        <button type="submit" class="btn btn-danger mb-2">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php include(__DIR__ . '/../footer.php'); ?>