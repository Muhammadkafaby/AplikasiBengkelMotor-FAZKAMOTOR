<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .pos-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 1.5rem;
        height: calc(100vh - 200px);
    }

    @media (max-width: 1200px) {
        .pos-container {
            grid-template-columns: 1fr;
            height: auto;
        }
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
        overflow-y: auto;
        max-height: calc(100vh - 320px);
        padding: 0.5rem;
    }

    .product-card {
        background: #fff;
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        text-align: center;
    }

    [data-bs-theme="dark"] .product-card {
        background: #1e293b;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }

    .product-card.out-of-stock {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .product-card-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 0.75rem;
    }

    .product-card-placeholder {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        color: #94a3b8;
    }

    [data-bs-theme="dark"] .product-card-placeholder {
        background: #334155;
    }

    .cart-panel {
        background: #fff;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    [data-bs-theme="dark"] .cart-panel {
        background: #1e293b;
    }

    .cart-header {
        padding: 1.25rem;
        border-bottom: 1px solid #e2e8f0;
    }

    [data-bs-theme="dark"] .cart-header {
        border-color: #334155;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        max-height: 300px;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }

    [data-bs-theme="dark"] .cart-item {
        background: #0f172a;
    }

    .cart-item-qty {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .cart-item-qty input {
        width: 50px;
        text-align: center;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        padding: 0.25rem;
    }

    .cart-summary {
        padding: 1.25rem;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 0 0 16px 16px;
    }

    [data-bs-theme="dark"] .cart-summary {
        background: #0f172a;
        border-color: #334155;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .summary-row.total {
        font-size: 1.25rem;
        font-weight: 700;
        color: #667eea;
        border-top: 2px solid #e2e8f0;
        padding-top: 0.75rem;
        margin-top: 0.5rem;
    }

    .btn-pay {
        width: 100%;
        padding: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 12px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        margin-top: 1rem;
    }

    .btn-pay:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    .category-tabs {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }

    .category-tab {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: #f1f5f9;
        border: none;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.2s;
    }

    [data-bs-theme="dark"] .category-tab {
        background: #334155;
        color: #e2e8f0;
    }

    .category-tab.active {
        background: #667eea;
        color: #fff;
    }

    .search-box {
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .search-box input {
        padding-left: 2.5rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pos-container">
    <!-- Products Panel -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h5 class="mb-0">
                    <i class="fas fa-box text-primary me-2"></i>
                    Pilih Produk
                </h5>
                <div class="search-box" style="width: 300px;">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="searchProduct" placeholder="Cari produk...">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="category-tabs" id="categoryTabs">
                <button class="category-tab active" data-category="all">Semua</button>
                <?php
                $categories = [];
                foreach ($products as $p) {
                    if ($p['category_name'] && !in_array($p['category_name'], $categories)) {
                        $categories[] = $p['category_name'];
                    }
                }
                foreach ($categories as $cat):
                    ?>
                    <button class="category-tab" data-category="<?= esc($cat) ?>">
                        <?= esc($cat) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="product-grid" id="productGrid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card <?= ($product['type'] == 'sparepart' && $product['stock'] <= 0) ? 'out-of-stock' : '' ?>"
                        data-id="<?= $product['id'] ?>" data-name="<?= esc($product['name']) ?>"
                        data-price="<?= $product['sell_price'] ?>" data-stock="<?= $product['stock'] ?>"
                        data-type="<?= $product['type'] ?>" data-category="<?= esc($product['category_name'] ?? '') ?>">
                        <?php if ($product['image']): ?>
                            <img src="<?= base_url('uploads/products/' . $product['image']) ?>" class="product-card-img">
                        <?php else: ?>
                            <div class="product-card-placeholder">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                        <?php endif; ?>
                        <div class="fw-semibold small mb-1">
                            <?= esc($product['name']) ?>
                        </div>
                        <div class="text-primary fw-bold">Rp
                            <?= number_format($product['sell_price'], 0, ',', '.') ?>
                        </div>
                        <?php if ($product['type'] == 'sparepart'): ?>
                            <small class="<?= $product['stock'] <= $product['min_stock'] ? 'text-danger' : 'text-muted' ?>">
                                Stok:
                                <?= $product['stock'] ?>
                            </small>
                        <?php else: ?>
                            <small class="text-success"><i class="fas fa-wrench"></i> Jasa</small>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Cart Panel -->
    <div class="cart-panel">
        <div class="cart-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart text-primary me-2"></i>
                    Keranjang
                </h5>
                <button class="btn btn-sm btn-outline-danger" onclick="clearCart()">
                    <i class="fas fa-trash"></i> Kosongkan
                </button>
            </div>
            <div class="mt-3">
                <select class="form-select form-select-sm" id="customerSelect">
                    <option value="">-- Pilih Customer (Opsional) --</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>">
                            <?= esc($customer['name']) ?> -
                            <?= esc($customer['phone']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="text-center text-muted py-5" id="emptyCart">
                <i class="fas fa-shopping-basket fa-3x mb-3"></i>
                <p class="mb-0">Keranjang masih kosong</p>
            </div>
        </div>

        <div class="cart-summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotal">Rp 0</span>
            </div>
            <div class="summary-row">
                <span>Diskon</span>
                <input type="number" class="form-control form-control-sm" id="discountInput"
                    style="width: 100px; text-align: right;" value="0" min="0">
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="grandTotal">Rp 0</span>
            </div>

            <div class="mt-3">
                <label class="form-label small">Metode Pembayaran</label>
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="paymentMethod" id="payCash" value="cash" checked>
                    <label class="btn btn-outline-primary" for="payCash"><i class="fas fa-money-bill me-1"></i>
                        Cash</label>

                    <input type="radio" class="btn-check" name="paymentMethod" id="payTransfer" value="transfer">
                    <label class="btn btn-outline-primary" for="payTransfer"><i class="fas fa-university me-1"></i>
                        Transfer</label>

                    <input type="radio" class="btn-check" name="paymentMethod" id="payQris" value="qris">
                    <label class="btn btn-outline-primary" for="payQris"><i class="fas fa-qrcode me-1"></i> QRIS</label>
                </div>
            </div>

            <div class="mt-3" id="cashPaymentSection">
                <label class="form-label small">Jumlah Bayar</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="paidAmount" min="0">
                </div>
                <div class="mt-2 d-flex justify-content-between">
                    <span>Kembalian:</span>
                    <span class="fw-bold text-success" id="changeAmount">Rp 0</span>
                </div>
            </div>

            <button class="btn btn-success btn-pay" id="btnPay" onclick="processPayment()" disabled>
                <i class="fas fa-check-circle me-2"></i> Bayar Sekarang
            </button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let cart = [];

    // Add product to cart
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function () {
            if (this.classList.contains('out-of-stock')) {
                Swal.fire('Stok Habis', 'Produk ini sedang tidak tersedia', 'warning');
                return;
            }

            const id = parseInt(this.dataset.id);
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            const stock = parseInt(this.dataset.stock);
            const type = this.dataset.type;

            const existingItem = cart.find(item => item.product_id === id);

            if (existingItem) {
                if (type === 'sparepart' && existingItem.qty >= stock) {
                    Swal.fire('Stok Tidak Cukup', 'Stok tersedia: ' + stock, 'warning');
                    return;
                }
                existingItem.qty++;
                existingItem.subtotal = existingItem.qty * existingItem.price;
            } else {
                cart.push({
                    product_id: id,
                    name: name,
                    price: price,
                    qty: 1,
                    stock: stock,
                    type: type,
                    discount: 0,
                    subtotal: price
                });
            }

            renderCart();
        });
    });

    // Render cart
    function renderCart() {
        const container = document.getElementById('cartItems');
        const emptyCart = document.getElementById('emptyCart');

        if (cart.length === 0) {
            emptyCart.style.display = 'block';
            container.innerHTML = emptyCart.outerHTML;
            updateTotals();
            return;
        }

        let html = '';
        cart.forEach((item, index) => {
            html += `
                <div class="cart-item">
                    <div class="flex-grow-1">
                        <div class="fw-semibold">${item.name}</div>
                        <div class="text-muted small">Rp ${formatNumber(item.price)} x ${item.qty}</div>
                    </div>
                    <div class="cart-item-qty">
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQty(${index}, -1)">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" value="${item.qty}" min="1" max="${item.type === 'sparepart' ? item.stock : 999}" 
                               onchange="setQty(${index}, this.value)">
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQty(${index}, 1)">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger ms-2" onclick="removeItem(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="fw-bold ms-3" style="min-width: 100px; text-align: right;">
                        Rp ${formatNumber(item.subtotal)}
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        updateTotals();
    }

    // Update quantity
    function updateQty(index, delta) {
        const item = cart[index];
        const newQty = item.qty + delta;

        if (newQty < 1) {
            removeItem(index);
            return;
        }

        if (item.type === 'sparepart' && newQty > item.stock) {
            Swal.fire('Stok Tidak Cukup', 'Stok tersedia: ' + item.stock, 'warning');
            return;
        }

        item.qty = newQty;
        item.subtotal = item.qty * item.price;
        renderCart();
    }

    // Set quantity directly
    function setQty(index, value) {
        const qty = parseInt(value) || 1;
        cart[index].qty = qty;
        cart[index].subtotal = qty * cart[index].price;
        renderCart();
    }

    // Remove item
    function removeItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    // Clear cart
    function clearCart() {
        Swal.fire({
            title: 'Kosongkan Keranjang?',
            text: 'Semua item akan dihapus',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kosongkan',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                cart = [];
                renderCart();
            }
        });
    }

    // Update totals
    function updateTotals() {
        const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const discount = parseFloat(document.getElementById('discountInput').value) || 0;
        const grandTotal = subtotal - discount;

        document.getElementById('subtotal').textContent = 'Rp ' + formatNumber(subtotal);
        document.getElementById('grandTotal').textContent = 'Rp ' + formatNumber(grandTotal);
        document.getElementById('btnPay').disabled = cart.length === 0;

        updateChange();
    }

    // Update change
    function updateChange() {
        const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const discount = parseFloat(document.getElementById('discountInput').value) || 0;
        const grandTotal = subtotal - discount;
        const paid = parseFloat(document.getElementById('paidAmount').value) || 0;
        const change = paid - grandTotal;

        document.getElementById('changeAmount').textContent = 'Rp ' + formatNumber(Math.max(0, change));
    }

    // Discount input
    document.getElementById('discountInput').addEventListener('input', updateTotals);
    document.getElementById('paidAmount').addEventListener('input', updateChange);

    // Process payment
    function processPayment() {
        const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const discount = parseFloat(document.getElementById('discountInput').value) || 0;
        const grandTotal = subtotal - discount;
        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
        const paid = parseFloat(document.getElementById('paidAmount').value) || grandTotal;

        if (paymentMethod === 'cash' && paid < grandTotal) {
            Swal.fire('Pembayaran Kurang', 'Jumlah bayar harus lebih dari atau sama dengan total', 'error');
            return;
        }

        const data = {
            items: cart,
            customer_id: document.getElementById('customerSelect').value,
            discount: discount,
            tax: 0,
            payment_method: paymentMethod,
            paid: paid
        };

        Swal.fire({
            title: 'Proses Pembayaran?',
            html: `
                <div class="text-start">
                    <p><strong>Total:</strong> Rp ${formatNumber(grandTotal)}</p>
                    <p><strong>Bayar:</strong> Rp ${formatNumber(paid)}</p>
                    <p><strong>Kembalian:</strong> Rp ${formatNumber(paid - grandTotal)}</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            confirmButtonText: 'Ya, Proses',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                fetch('<?= base_url('pos/process') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            Swal.fire({
                                title: 'Transaksi Berhasil!',
                                html: `
                                <p>No. Invoice: <strong>${result.invoice_no}</strong></p>
                                <p>Kembalian: <strong>Rp ${formatNumber(paid - grandTotal)}</strong></p>
                            `,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Cetak Struk',
                                cancelButtonText: 'Selesai'
                            }).then(res => {
                                if (res.isConfirmed) {
                                    window.open('<?= base_url('transaction/print/') ?>' + result.transaction_id, '_blank');
                                }
                                cart = [];
                                renderCart();
                                document.getElementById('discountInput').value = 0;
                                document.getElementById('paidAmount').value = '';
                                document.getElementById('customerSelect').value = '';
                            });
                        } else {
                            Swal.fire('Error', result.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Terjadi kesalahan', 'error');
                        console.error(error);
                    });
            }
        });
    }

    // Search products
    document.getElementById('searchProduct').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(card => {
            const name = card.dataset.name.toLowerCase();
            card.style.display = name.includes(keyword) ? 'block' : 'none';
        });
    });

    // Category filter
    document.querySelectorAll('.category-tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const category = this.dataset.category;
            document.querySelectorAll('.product-card').forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Toggle cash payment section
    document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.getElementById('cashPaymentSection').style.display =
                this.value === 'cash' ? 'block' : 'none';
        });
    });

    // Format number
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }
</script>
<?= $this->endSection() ?>