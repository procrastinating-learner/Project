let myModal = document.getElementById('addProductModal');

myModal?.addEventListener('shown.bs.modal', function () {});
let myModal2 = document.getElementById('addCategoryModal');

myModal2?.addEventListener('shown.bs.modal', function () {});
document.addEventListener('DOMContentLoaded', function () {
  let editProductModal = document.getElementById('editProductModal');
  let editCategoryModal = document.getElementById('editCategoryModal');
  console.log(editCategoryModal);
  editCategoryModal?.addEventListener('show.bs.modal', function (event) {
    let button = event.relatedTarget;
    let categoryId = button.dataset.categoryId;
    let categoryName = button.dataset.categoryName;
    console.log(categoryName, 'name');
    editCategoryModal.querySelector('#edit_category_id').value = categoryId;
    editCategoryModal.querySelector('#edit_category_name').value = categoryName;
  });
  editProductModal?.addEventListener('show.bs.modal', function (event) {
    let button = event.relatedTarget;
    let productId = button.dataset.productId;
    let productName = button.dataset.productName;
    let productCategory = button.dataset.productCategory;
    let productDescription = button.dataset.productDescription;
    let productDetails = button.dataset.productDetails;
    let productPrice = button.dataset.productPrice;
    let productStockQuantity = button.dataset.productStockQuantity;
    editProductModal.querySelector('#edit_product_id').value = productId;
    editProductModal.querySelector('#edit_product_name').value = productName;
    editProductModal.querySelector('#edit_product_category').value =
      productCategory;
    editProductModal.querySelector('#edit_product_description').value =
      productDescription;
    editProductModal.querySelector('#edit_product_details').value =
      productDetails;
    editProductModal.querySelector('#edit_product_price').value = productPrice;
    editProductModal.querySelector('#edit_product_stock_quantity').value =
      productStockQuantity;
  });
});
