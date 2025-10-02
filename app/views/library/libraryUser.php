<?php include(__DIR__ . '/../header.php'); ?>

<!-- Редване на хтмл-а само ако libraryUsers е сетнат -->
<?php if (isset($libraryUsers)) : ?>
    <div class="container mb-5">
        <h2 class="text-center my-3">All members the library</h2>
        <div class="text-center mb-3">
            <a href="/home" class="btn btn-secondary mx-2">Home</a>
            <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#addMemberModal">Add member</button>
        </div>

        <!-- Удачно съобщение ако libraryUsers е празен -->
        <?php if (empty($libraryUsers)) : ?>
            <p class="text-center text-danger">No results found</p>
        <?php endif; ?>

        <!-- Модал от буутстрап -->
        <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMemberModalLabel">Add Member to Library</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="addMemberForm" action="/libraryUser/add">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" id="addMemberButton">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <ul class="list-group">
            <?php foreach ($libraryUsers as $index => $libraryUser) : ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        <h5><?php echo htmlspecialchars($libraryUser->getName()); ?></h5>
                        <p>Card: <?php echo htmlspecialchars($libraryUser->getLibraryCardNumber()); ?></p>
                    </div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#viewBorrowedItems_<?php echo $index; ?>">View borrowed items</button>

                    <!-- Модал(и) от буутстрап (за всеки един читател) -->
                    <!-- Всеки модал има в ид-то си индекса на читателя, за да може да се отвори правилния модал -->
                    <div class="modal fade" id="viewBorrowedItems_<?php echo $index; ?>" tabindex="-1" aria-labelledby="viewBorrowedItemsLabel_<?php echo $index; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewBorrowedItemsLabel_<?php echo $index; ?>"><?php echo htmlspecialchars($libraryUser->getName()); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <?php if (empty($libraryUser->getBorrowedWorks())) : ?>
                                            <p class="text-center text-danger">No items borrowed.</p>
                                        <?php else : ?>

                                            <h5>Borrowed items:</h5>
                                            <ul>
                                                <?php foreach ($libraryUser->getBorrowedWorks() as $work) : ?>
                                                    <?php
                                                    $faIcon = '';
                                                    if ($work instanceof Book) $faIcon = '<i class="fa-solid fa-book"></i>';
                                                    elseif ($work instanceof Magazine) $faIcon = '<i class="fa-solid fa-book-open"></i>';
                                                    elseif ($work instanceof Newspaper) $faIcon = '<i class="fa-solid fa-newspaper"></i>';
                                                    ?>
                                                    <li>
                                                        <?php echo $faIcon; ?>
                                                        <strong>Title:</strong> <?php echo htmlspecialchars($work->getTitle()); ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                    </div>
                                <?php endif; ?>
                                <div class="text-center mb-3">
                                    <button type="button" class="btn btn-warning me-3" onclick="toggleForm('borrowItemForm_<?php echo $index; ?>')">Borrow Item</button>
                                    <button type="button" class="btn btn-warning" onclick="toggleForm('returnItemForm_<?php echo $index; ?>')">Return Item</button>
                                </div>

                                <!-- Форми от буутстрап (за всеки един читател) -->
                                <!-- Всяка форма има в ид-то си индекса на читателя за да може да се пасне на js-са правилната форма -->
                                <form method="POST" class="initially-hidden" id="borrowItemForm_<?php echo $index; ?>" action="/libraryUser/borrow">
                                    <div class="mb-3">
                                        <label for="itemToBorrow" class="form-label">Select item to borrow</label>
                                        <div class="d-flex">
                                            <input type="hidden" name="libraryCardNumber" value="<?php echo htmlspecialchars($libraryUser->getLibraryCardNumber()); ?>">
                                            <select class="form-select me-2" id="itemToBorrow" name="itemToBorrow" required>
                                                <?php foreach ($_SESSION['literaryWorks'] as $literaryWork) : ?>
                                                    <?php
                                                    //Проверявам дали произведението е книга и има наличност, или не е книга
                                                    //и в двата случая проверявам дали не е заето
                                                    //условията са верни, може да се рендне тази опция
                                                    $canBorrow = false;
                                                    if ($literaryWork instanceof Book) {
                                                        if ($literaryWork->getStock() > 0 && !$libraryUser->hasBorrowed($literaryWork)) {
                                                            $canBorrow = true;
                                                        }
                                                    } else {
                                                        if (!$libraryUser->hasBorrowed($literaryWork)) {
                                                            $canBorrow = true;
                                                        }
                                                    }
                                                    if ($canBorrow) :
                                                    ?>
                                                        <option value="<?php echo htmlspecialchars($literaryWork->getISBN()); ?>">
                                                            <?php echo htmlspecialchars($literaryWork->getTitle()); ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="btn btn-success">Borrow</button>
                                        </div>
                                    </div>
                                </form>

                                <form method="POST" class="initially-hidden" id="returnItemForm_<?php echo $index; ?>" action="/libraryUser/return">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Select item to return</label>
                                        <div class="d-flex">
                                            <input type="hidden" name="libraryCardNumber" value="<?php echo htmlspecialchars($libraryUser->getLibraryCardNumber()); ?>">
                                            <select class="form-select me-2" id="itemToReturn" name="itemToReturn" required>
                                                <?php foreach ($libraryUser->getBorrowedWorks() as $literaryWork) : ?>
                                                    <option value="<?php echo htmlspecialchars($literaryWork->getISBN()); ?>"><?php echo htmlspecialchars($literaryWork->getTitle()); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="btn btn-success">Return</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                                </div>
                            </div>
                        </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <script src="/../scripts/libraryUser/index.js"></script>
    </div>
<?php endif; ?>

<?php include(__DIR__ . '/../footer.php'); ?>