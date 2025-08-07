from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import pytest

class TestProductCRUD:

    def login_as_admin(self, driver, base_url):
        """Helper method to login as admin - reduces code duplication"""
        driver.get(f"{base_url}/login")
        driver.find_element(By.ID, "input-email").send_keys("admin@mail.com")
        driver.find_element(By.ID, "input-password").send_keys("test123")
        driver.find_element(By.ID, "button-login").click()
        WebDriverWait(driver, 10).until(EC.url_contains("/admin/dashboard"))

        # Handle menu toggle if needed
        try:
            menu_toggle = WebDriverWait(driver, 3).until(
                EC.element_to_be_clickable((By.ID, "pushmenu"))
            )
            menu_toggle.click()
        except:
            pass

    def navigate_to_products(self, driver):
        """Helper method to navigate to products page"""
        view_products_link = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.PARTIAL_LINK_TEXT, "View Products"))
        )
        view_products_link.click()
        WebDriverWait(driver, 10).until(EC.url_contains("/admin/products"))

    def test_view_products_after_login(self, driver, base_url):
        """Test viewing products page after login"""
        self.login_as_admin(driver, base_url)
        self.navigate_to_products(driver)

        # Verify we're on the products page
        assert "/admin/products" in driver.current_url
        assert "product" in driver.page_source.lower()

    def test_add_product(self, driver, base_url):
        """Test adding a new product"""
        self.login_as_admin(driver, base_url)
        self.navigate_to_products(driver)

        # Click add button
        add_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "add-button"))
        )
        add_button.click()

        # Wait for create page
        WebDriverWait(driver, 10).until(EC.url_contains("/admin/products/create"))

        # Fill product details
        product_name = "Test Product Selenium"
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "product_name"))
        ).send_keys(product_name)

        driver.find_element(By.ID, "sell_price").send_keys("100")
        driver.find_element(By.ID, "buy_price").send_keys("80")
        driver.find_element(By.ID, "stock").send_keys("50")

        # FIXED: Added parentheses to actually call the click method
        driver.find_element(By.ID, "submit-button").click()

        # Wait for redirect after successful submission
        WebDriverWait(driver, 10).until(
            lambda driver: "/admin/products/create" not in driver.current_url
        )

        # Verify product was added (optional but recommended)
        assert product_name in driver.page_source

    def test_edit_product(self, driver, base_url):
        """Test editing an existing product"""
        self.login_as_admin(driver, base_url)
        self.navigate_to_products(driver)

        # Find and click first edit button
        edit_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Edit')]"))
        )

        # Store original product name for verification
        original_row = edit_button.find_element(By.XPATH, "./ancestor::tr")
        original_name = original_row.find_element(By.TAG_NAME, "td").text

        edit_button.click()

        # Wait for edit page
        WebDriverWait(driver, 10).until(
            lambda driver: "edit" in driver.current_url.lower()
        )

        # Edit product details
        updated_name = "Test Product Updated Selenium"

        product_name_field = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "product_name"))
        )
        product_name_field.clear()
        product_name_field.send_keys(updated_name)

        sell_price_field = driver.find_element(By.ID, "sell_price")
        sell_price_field.clear()
        sell_price_field.send_keys("11000")

        buy_price_field = driver.find_element(By.ID, "buy_price")
        buy_price_field.clear()
        buy_price_field.send_keys("8000")

        stock_field = driver.find_element(By.ID, "stock")
        stock_field.clear()
        stock_field.send_keys("55")

        # Submit changes
        submit_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "submit-button"))
        )
        submit_button.click()

        # Wait for redirect
        WebDriverWait(driver, 10).until(
            lambda driver: "edit" not in driver.current_url.lower()
        )

        # Verify changes were saved
        assert updated_name in driver.page_source
        assert original_name not in driver.page_source

    def test_delete_product(self, driver, base_url):
        """Test deleting a product"""
        self.login_as_admin(driver, base_url)
        self.navigate_to_products(driver)

        # Wait for products to load
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, "delete-button"))
        )

        # Get product name before deletion for verification
        first_row = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, "//table/tbody/tr[1]"))
        )
        product_name = first_row.find_element(By.TAG_NAME, "td").text

        # Click delete button
        delete_button = first_row.find_element(By.CLASS_NAME, "delete-button")
        delete_button.click()

        # Handle confirmation dialog
        WebDriverWait(driver, 5).until(EC.alert_is_present())
        alert = driver.switch_to.alert
        alert.accept()

        # Wait for page refresh/update
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.TAG_NAME, "body"))
        )

        # Add explicit wait to ensure DOM is updated
        time.sleep(2)

        # Verify product was deleted
        assert product_name not in driver.page_source
