<!DOCTYPE html>
<html lang="lv">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Zivju Veikals</title>
     <style>
          body {
               font-family: Arial, sans-serif;
               margin: 0;
               padding: 0;
               line-height: 1.6;
          }

          .container {
               max-width: 1200px;
               margin: 0 auto;
               padding: 0 20px;
          }

          h1 {
               text-align: center;
               margin-top: 20px;
               margin-bottom: 20px;
          }

          nav {
               background: #2c3e50;
               color: white;
               padding: 1rem 0;
               margin-bottom: 20px;
          }

          nav .container {
               display: flex;
               justify-content: space-between;
               align-items: center;
          }

          nav a {
               color: white;
               text-decoration: none;
               margin: 0 10px;
               padding: 5px 10px;
          }

          nav a:hover {
               background: #34495e;
               border-radius: 3px;
          }

          .alert {
               padding: 12px;
               margin: 15px 0;
               border-radius: 4px;
               border: 1px solid transparent;
          }

          .alert-success {
               background: #d4edda;
               color: #155724;
               border-color: #c3e6cb;
          }

          .alert-error {
               background: #f8d7da;
               color: #721c24;
               border-color: #f5c6cb;
          }

          .form-group {
               margin-bottom: 15px;
          }

          .form-group label {
               display: block;
               margin-bottom: 5px;
               font-weight: bold;
          }

          .form-group input,
          .form-group textarea,
          .form-group select {
               width: 100%;
               padding: 8px;
               border: 1px solid #ddd;
               border-radius: 4px;
               box-sizing: border-box;
          }

          form input[type="file"] {
               border: none;
               padding-left: 0;
          }

          button {
               background: #3498db;
               color: white;
               padding: 10px 20px;
               border: none;
               border-radius: 4px;
               cursor: pointer;
               transition: background 0.3s;
          }

          button:hover {
               background: #2980b9;
          }

          .delete-btn {
               background: #dc3545;
               color: white;
               padding: 8px 20px;
               border-radius: 4px;
               text-decoration: none;
               white-space: nowrap;
               border: none;
               cursor: pointer;
               font-size: 14px;
          }

          .delete-btn:hover {
               background: #c82333;
          }

          .edit-btn {
               background: green;
          }

          .edit-btn:hover {
               background: darkgreen;
          }

          .fish-grid {
               display: flex;
               flex-wrap: wrap;
               justify-content: center;
               gap: 20px;
               padding: 20px 0;
          }

          .fish-card {
               border: 1px solid #ddd;
               border-radius: 12px;
               padding: 20px;
               text-align: center;
               width: 300px;
               min-height: 500px;
               box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
               display: flex;
               flex-direction: column;
               justify-content: space-between;
               background-color: #fff;
               transition: transform 0.3s ease, box-shadow 0.3s ease;
          }

          .fish-card:hover {
               transform: translateY(-5px);
               box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
          }

          .fish-card a:hover {
               background: #2980b9 !important;
               transform: scale(1.05);
          }

          .fish-card img:hover {
               opacity: 0.9;
          }

          .fish-card h2 {
               margin-top: 0;
               margin-bottom: 12px;
               color: #2c3e50;
               font-size: 1.4em;
               min-height: 50px;
               display: flex;
               align-items: center;
               justify-content: center;
          }

          .fish-card .price {
               font-size: 1.3em;
               font-weight: bold;
               color: #27ae60;
               margin: 10px 0;
          }

          .fish-card img {
               width: 100%;
               height: 200px;
               object-fit: contain;
               display: block;
               margin-bottom: 15px;
               border-radius: 8px;
               background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
               padding: 15px;
               border: 1px solid #e9ecef;
               transition: opacity 0.3s ease;
          }

          .fish-card .no-image {
               width: 100%;
               height: 200px;
               background-color: #f8f8f8;
               display: flex;
               align-items: center;
               justify-content: center;
               color: #999;
               border: 1px dashed #ccc;
               border-radius: 4px;
               margin-bottom: 15px;
               font-style: italic;
          }

          .fish-card p {
               font-size: 0.95em;
               color: #555;
               margin-bottom: 8px;
          }

          .fish-card a {
               display: inline-block;
               background: #3498db;
               color: white;
               padding: 10px 20px;
               border-radius: 6px;
               text-decoration: none;
               margin-top: auto;
               transition: background 0.3s ease, transform 0.2s ease;
               font-weight: bold;
          }

          .fish-card a:hover {
               background: #2980b9;
               transform: scale(1.05);
          }

          /* Batch Cards */
          .batch-card a:hover {
               background: #229954 !important;
               transform: translateY(-2px);
          }

          .batch-card a:hover {
               opacity: 0.9;
               transform: translateY(-2px);
          }

          .batch-card button:hover {
               background: #c0392b !important;
               transform: translateY(-2px);
          }

          .fish-row {
               transition: all 0.3s ease;
          }

          .fish-row:hover {
               background: #f0f0f0 !important;
          }

          .reservation-container {
               max-width: 600px;
               margin: 0 auto;
               background: white;
               padding: 30px;
               border-radius: 8px;
               box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          }

          .reservation-item {
               background: white;
               padding: 20px;
               margin-bottom: 15px;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
               display: flex;
               justify-content: space-between;
               align-items: center;
               transition: transform 0.2s;
          }

          .reservation-item:hover {
               transform: translateY(-2px);
               box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
          }

          .reservation-info {
               flex: 1;
          }

          .reservation-info h3 {
               margin: 0 0 10px 0;
               color: #2c3e50;
          }

          .reservation-info p {
               margin: 5px 0;
               color: #555;
               font-size: 14px;
          }

          .status-badge {
               display: inline-block;
               padding: 5px 15px;
               border-radius: 20px;
               font-weight: bold;
               font-size: 13px;
               margin-right: 10px;
          }

          .status-pending {
               background: #fff3cd;
               color: #856404;
          }

          .status-confirmed {
               background: #d1ecf1;
               color: #0c5460;
          }

          .status-completed {
               background: #d4edda;
               color: #155724;
          }

          .status-cancelled {
               background: #f8d7da;
               color: #721c24;
          }

          .view-btn {
               background: #3498db;
               color: white;
               padding: 8px 20px;
               border-radius: 4px;
               text-decoration: none;
               white-space: nowrap;
               margin-right: 10px;
          }

          .view-btn:hover {
               background: #2980b9;
          }

          .empty-state {
               text-align: center;
               padding: 60px 20px;
               color: #999;
          }

          .empty-state i {
               font-size: 48px;
               margin-bottom: 20px;
          }

          .reservation-actions {
               display: flex;
               gap: 10px;
               align-items: center;
          }

          .button-group {
               display: flex;
               gap: 10px;
               margin-top: 20px;
          }

          .btn-secondary {
               background: #757575;
               color: white;
               padding: 10px 20px;
               border-radius: 4px;
               text-decoration: none;
               display: inline-block;
          }

          .btn-secondary:hover {
               background: #616161;
          }

          .reservation-container {
               max-width: 600px;
               margin: 0 auto;
               background: white;
               padding: 30px;
               border-radius: 8px;
               box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          }

          .fish-info {
               background: #f9f9f9;
               padding: 15px;
               border-radius: 5px;
               margin-bottom: 25px;
               border-left: 4px solid #4CAF50;
          }

          .fish-info p {
               margin: 5px 0;
               color: #555;
          }

          .info-text {
               font-size: 13px;
               color: #666;
               margin-top: 5px;
          }

          .detail-section {
               background: #f9f9f9;
               padding: 20px;
               border-radius: 5px;
               margin: 20px 0;
          }

          .detail-row {
               display: flex;
               justify-content: space-between;
               padding: 10px 0;
               border-bottom: 1px solid #e0e0e0;
          }

          .detail-row:last-child {
               border-bottom: none;
          }

          .detail-label {
               font-weight: bold;
               color: #555;
          }

          .detail-value {
               color: #333;
          }

          .notes-box {
               background: #fffbf0;
               padding: 15px;
               border-radius: 5px;
               border-left: 4px solid #ffc107;
               margin-top: 20px;
          }

          .checkout-container {
               max-width: 1000px;
               margin: 0 auto;
               padding: 20px;
          }

          .checkout-grid {
               display: grid;
               grid-template-columns: 1fr 400px;
               gap: 30px;
               margin-top: 20px;
          }

          .checkout-section {
               background: white;
               padding: 25px;
               border-radius: 8px;
               box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
               margin-bottom: 20px;
          }

          .section-title {
               font-size: 1.3em;
               font-weight: bold;
               color: #2c3e50;
               margin-bottom: 20px;
               padding-bottom: 10px;
               border-bottom: 2px solid #ecf0f1;
          }

          .form-label {
               display: block;
               margin-bottom: 8px;
               font-weight: 600;
               color: #2c3e50;
          }

          .form-input {
               width: 100%;
               padding: 12px;
               border: 2px solid #ecf0f1;
               border-radius: 6px;
               font-size: 1em;
               transition: border-color 0.3s;
          }

          .form-input:focus {
               outline: none;
               border-color: #3498db;
          }

          .form-textarea {
               min-height: 100px;
               resize: vertical;
          }

          .error-message {
               color: #e74c3c;
               font-size: 0.9em;
               margin-top: 5px;
          }

          .cart-item {
               background: #f8f9fa;
               padding: 15px;
               margin-bottom: 10px;
               border-radius: 6px;
               border-left: 4px solid #3498db;
          }

          .cart-item-header {
               display: flex;
               justify-content: space-between;
               align-items: start;
               margin-bottom: 8px;
          }

          .item-name {
               font-weight: bold;
               color: #2c3e50;
               font-size: 1.1em;
          }

          .item-price {
               font-weight: bold;
               color: #27ae60;
          }

          .item-details {
               color: #666;
               font-size: 0.9em;
               line-height: 1.4;
          }

          .item-details p {
               margin: 3px 0;
          }

          .summary-row {
               display: flex;
               justify-content: space-between;
               padding: 12px 0;
               border-bottom: 1px solid #ecf0f1;
          }

          .summary-total {
               font-size: 1.3em;
               font-weight: bold;
               color: #2c3e50;
               padding-top: 15px;
               border-top: 2px solid #ecf0f1;
          }

          .checkout-btn {
               width: 100%;
               background: #27ae60;
               color: white;
               padding: 15px;
               border: none;
               border-radius: 6px;
               font-size: 1.1em;
               font-weight: bold;
               cursor: pointer;
               margin-top: 20px;
               transition: background 0.3s;
          }

          .checkout-btn:hover {
               background: #229954;
          }

          .checkout-btn:disabled {
               background: #95a5a6;
               cursor: not-allowed;
          }

          .back-btn {
               display: inline-block;
               background: #757575;
               color: white;
               padding: 12px 24px;
               border-radius: 6px;
               text-decoration: none;
               margin-top: 15px;
               transition: background 0.3s;
          }

          .back-btn:hover {
               background: #616161;
          }

          .info-box {
               background: #d1ecf1;
               border: 1px solid #bee5eb;
               border-radius: 6px;
               padding: 15px;
               margin-bottom: 20px;
               color: #0c5460;
          }

          .info-box p {
               margin: 5px 0;
               font-size: 0.9em;
          }

          .cart-container {
               max-width: 1000px;
               margin: 0 auto;
          }

          .cart-item {
               background: white;
               padding: 20px;
               margin-bottom: 15px;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
               display: grid;
               grid-template-columns: 1fr 150px 150px 100px 80px;
               gap: 15px;
               align-items: center;
          }

          .cart-item:hover {
               box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
          }

          .item-info h3 {
               margin: 0 0 5px 0;
               color: #2c3e50;
          }

          .item-info p {
               margin: 3px 0;
               color: #666;
               font-size: 0.9em;
          }

          .quantity-input {
               display: flex;
               align-items: center;
               gap: 5px;
          }

          .quantity-input input {
               width: 70px;
               padding: 8px;
               border: 1px solid #ddd;
               border-radius: 4px;
               text-align: center;
          }

          .quantity-input button {
               background: #3498db;
               color: white;
               border: none;
               padding: 8px 12px;
               border-radius: 4px;
               cursor: pointer;
               font-size: 0.85em;
          }

          .quantity-input button:hover {
               background: #2980b9;
          }

          .price {
               font-size: 1.2em;
               font-weight: bold;
               color: #27ae60;
               text-align: right;
          }

          .remove-btn {
               background: #e74c3c;
               color: white;
               border: none;
               padding: 8px;
               border-radius: 4px;
               cursor: pointer;
               font-size: 1.2em;
          }

          .remove-btn:hover {
               background: #c0392b;
          }

          .cart-summary {
               background: white;
               padding: 25px;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
               margin-top: 20px;
          }

          .summary-row {
               display: flex;
               justify-content: space-between;
               padding: 10px 0;
               border-bottom: 1px solid #eee;
          }

          .summary-total {
               font-size: 1.5em;
               font-weight: bold;
               color: #2c3e50;
               padding-top: 15px;
          }

          .checkout-btn {
               width: 100%;
               background: #27ae60;
               color: white;
               padding: 15px;
               border: none;
               border-radius: 6px;
               font-size: 1.1em;
               font-weight: bold;
               cursor: pointer;
               margin-top: 15px;
          }

          .checkout-btn:hover {
               background: #229954;
          }

          .clear-cart-btn {
               background: #95a5a6;
               color: white;
               padding: 10px 20px;
               border: none;
               border-radius: 4px;
               cursor: pointer;
               margin-top: 10px;
          }

          .clear-cart-btn:hover {
               background: #7f8c8d;
          }

          .empty-cart {
               text-align: center;
               padding: 60px 20px;
               background: white;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
          }

          .success-container {
               max-width: 800px;
               margin: 0 auto;
               text-align: center;
               padding: 40px 20px;
          }

          .success-icon {
               font-size: 80px;
               color: #27ae60;
               margin-bottom: 20px;
          }

          .success-title {
               color: #2c3e50;
               font-size: 2em;
               margin-bottom: 15px;
          }

          .success-message {
               color: #555;
               font-size: 1.1em;
               line-height: 1.6;
               margin-bottom: 30px;
          }

          .reservation-summary {
               background: white;
               padding: 25px;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
               margin: 30px 0;
               text-align: left;
          }

          .summary-item {
               padding: 15px;
               border-bottom: 1px solid #eee;
               display: flex;
               justify-content: space-between;
               align-items: center;
          }

          .summary-item:last-child {
               border-bottom: none;
          }

          .item-name {
               font-weight: bold;
               color: #2c3e50;
          }

          .item-details {
               color: #666;
               font-size: 0.9em;
               margin-top: 5px;
          }

          .info-box {
               background: #e8f5e9;
               border-left: 4px solid #27ae60;
               padding: 20px;
               border-radius: 5px;
               margin: 20px 0;
               text-align: left;
          }

          .info-box h3 {
               color: #27ae60;
               margin: 0 0 10px 0;
          }

          .info-box ul {
               margin: 10px 0 0 20px;
               color: #555;
          }

          .info-box li {
               margin: 8px 0;
          }

          .action-buttons {
               display: flex;
               gap: 15px;
               justify-content: center;
               margin-top: 30px;
          }

          .btn {
               padding: 12px 30px;
               border-radius: 6px;
               text-decoration: none;
               font-weight: bold;
               transition: all 0.3s;
          }

          .btn-primary {
               background: #3498db;
               color: white;
          }

          .btn-primary:hover {
               background: #2980b9;
          }

          .btn-secondary {
               background: #95a5a6;
               color: white;
          }

          .btn-secondary:hover {
               background: #7f8c8d;
          }

          .summary-total {
               background: #f8f9fa;
               margin-top: 10px;
               padding: 20px;
               font-size: 1.2em;
          }

          .price-highlight {
               font-weight: bold;
               color: #27ae60;
               font-size: 1.1em;
          }

          .page-header {
               display: flex;
               justify-content: space-between;
               align-items: center;
               margin-bottom: 20px;
          }

          .text-center {
               text-align: center;
          }

          .text-right {
               text-align: right;
          }

          .bg-light {
               background: #f8f9fa;
          }

          .total-row {
               background: #f8f9fa;
               padding: 15px;
               font-size: 1.2em;
          }

          .total-amount {
               font-size: 1.3em;
               color: #27ae60;
          }

          .cancel-btn {
               font-size: 1em;
               font-weight: bold;
               padding: 12px 30px;
          }

          /* Order Detail Styles */
          .order-detail {
               max-width: 900px;
               margin: 0 auto;
          }

          .detail-card {
               background: white;
               padding: 25px;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
               margin-bottom: 20px;
          }

          .detail-card h2 {
               color: #2c3e50;
               margin: 0 0 20px 0;
               padding-bottom: 10px;
               border-bottom: 2px solid #3498db;
          }

          .order-header {
               display: flex;
               justify-content: space-between;
               align-items: center;
               margin-bottom: 20px;
          }

          .info-row {
               display: flex;
               justify-content: space-between;
               padding: 12px 0;
               border-bottom: 1px solid #eee;
          }

          .info-row:last-child {
               border-bottom: none;
          }

          .info-label {
               font-weight: bold;
               color: #555;
          }

          .info-value {
               color: #333;
               text-align: right;
          }

          .order-items-table {
               width: 100%;
               border-collapse: collapse;
               margin-top: 15px;
          }

          .order-items-table th {
               background: #f8f9fa;
               padding: 12px;
               text-align: left;
               font-weight: bold;
               border-bottom: 2px solid #dee2e6;
          }

          .order-items-table td {
               padding: 12px;
               border-bottom: 1px solid #eee;
          }

          .notes-box {
               background: #f8f9fa;
               padding: 15px;
               border-radius: 5px;
               margin-top: 15px;
               border-left: 4px solid #3498db;
          }

          .notes-box h3 {
               margin: 0 0 10px 0;
               color: #2c3e50;
               font-size: 1em;
          }

          .notes-box p {
               margin: 0;
               color: #555;
               line-height: 1.6;
          }

          .orders-container {
               max-width: 1000px;
               margin: 0 auto;
          }

          .order-card {
               background: white;
               padding: 25px;
               margin-bottom: 20px;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
               transition: transform 0.2s;
          }

          .order-card:hover {
               transform: translateY(-2px);
               box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
          }

          .order-header {
               display: flex;
               justify-content: space-between;
               align-items: center;
               margin-bottom: 15px;
               padding-bottom: 15px;
               border-bottom: 2px solid #eee;
          }

          .order-number {
               font-size: 1.3em;
               font-weight: bold;
               color: #2c3e50;
          }

          .order-items {
               margin: 15px 0;
          }

          .order-item {
               display: flex;
               justify-content: space-between;
               padding: 10px 0;
               border-bottom: 1px solid #f0f0f0;
          }

          .order-item:last-child {
               border-bottom: none;
          }

          .item-info {
               flex: 1;
          }

          .item-name {
               font-weight: bold;
               color: #2c3e50;
          }

          .item-details {
               color: #666;
               font-size: 0.9em;
               margin-top: 3px;
          }

          .item-price {
               font-weight: bold;
               color: #27ae60;
               white-space: nowrap;
               margin-left: 15px;
          }

          .order-footer {
               display: flex;
               justify-content: space-between;
               align-items: center;
               margin-top: 15px;
               padding-top: 15px;
               border-top: 2px solid #eee;
          }

          .order-total {
               font-size: 1.2em;
               font-weight: bold;
               color: #2c3e50;
          }

          .order-date {
               color: #666;
               font-size: 0.9em;
          }

          .order-actions {
               display: flex;
               gap: 10px;
               margin-top: 10px;
          }

          .checkout-container {
               max-width: 1200px;
               margin: 0 auto;
          }

          .checkout-grid {
               display: grid;
               grid-template-columns: 1.5fr 1fr;
               gap: 30px;
               margin-top: 30px;
          }

          .checkout-section {
               background: white;
               padding: 25px;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
          }

          .section-title {
               color: #2c3e50;
               margin: 0 0 20px 0;
               padding-bottom: 10px;
               border-bottom: 2px solid #3498db;
          }

          .cart-item {
               padding: 15px;
               border: 1px solid #eee;
               border-radius: 5px;
               margin-bottom: 15px;
          }

          .cart-item-header {
               display: flex;
               justify-content: space-between;
               margin-bottom: 10px;
          }

          .item-name {
               font-weight: bold;
               color: #2c3e50;
               font-size: 1.1em;
          }

          .item-price {
               font-weight: bold;
               color: #27ae60;
               font-size: 1.1em;
          }

          .item-details {
               color: #666;
               font-size: 0.9em;
          }

          .item-details p {
               margin: 5px 0;
          }

          .form-label {
               display: block;
               margin-bottom: 8px;
               font-weight: bold;
               color: #2c3e50;
          }

          .form-input {
               width: 100%;
               padding: 10px;
               border: 1px solid #ddd;
               border-radius: 4px;
               font-size: 1em;
          }

          .form-textarea {
               min-height: 100px;
               resize: vertical;
               font-family: Arial, sans-serif;
          }

          .info-text {
               font-size: 0.85em;
               color: #666;
               margin-top: 5px;
          }

          .error-message {
               color: #d32f2f;
               font-size: 0.9em;
               margin-top: 5px;
          }

          .summary-row {
               display: flex;
               justify-content: space-between;
               padding: 12px 0;
               border-bottom: 1px solid #eee;
          }

          .checkout-btn {
               width: 100%;
               background: #27ae60;
               color: white;
               padding: 15px;
               border: none;
               border-radius: 6px;
               font-size: 1.1em;
               font-weight: bold;
               cursor: pointer;
               margin-top: 20px;
          }

          .checkout-btn:hover {
               background: #229954;
          }

          .back-btn {
               display: block;
               text-align: center;
               margin-top: 15px;
               color: #3498db;
               text-decoration: none;
          }

          .reservation-detail {
               max-width: 1000px;
               margin: 0 auto;
          }

          .detail-grid {
               display: grid;
               grid-template-columns: 2fr 1fr;
               gap: 20px;
               margin-top: 20px;
          }

          .detail-card {
               background: white;
               padding: 25px;
               border-radius: 8px;
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
          }

          .detail-card h2 {
               color: #2c3e50;
               margin: 0 0 20px 0;
               padding-bottom: 10px;
               border-bottom: 2px solid #3498db;
          }

          .info-row {
               display: flex;
               justify-content: space-between;
               padding: 12px 0;
               border-bottom: 1px solid #eee;
          }

          .info-row:last-child {
               border-bottom: none;
          }

          .info-label {
               font-weight: bold;
               color: #555;
          }

          .info-value {
               color: #333;
               text-align: right;
          }

          .status-form {
               margin-top: 20px;
          }

          .status-form select {
               width: 100%;
               padding: 10px;
               border: 1px solid #ddd;
               border-radius: 4px;
               margin-bottom: 15px;
               font-size: 1em;
          }

          .status-form textarea {
               width: 100%;
               padding: 10px;
               border: 1px solid #ddd;
               border-radius: 4px;
               min-height: 100px;
               margin-bottom: 15px;
               font-family: Arial, sans-serif;
          }

          .status-form button {
               width: 100%;
               background: #3498db;
               color: white;
               padding: 12px;
               border: none;
               border-radius: 4px;
               font-size: 1em;
               font-weight: bold;
               cursor: pointer;
          }

          .status-form button:hover {
               background: #2980b9;
          }

          .notes-box {
               background: #f8f9fa;
               padding: 15px;
               border-radius: 5px;
               margin-top: 15px;
               border-left: 4px solid #3498db;
          }

          .notes-box h3 {
               margin: 0 0 10px 0;
               color: #2c3e50;
               font-size: 1em;
          }

          .notes-box p {
               margin: 0;
               color: #555;
               line-height: 1.6;
          }

          .warning-box {
               background: #fff3cd;
               border-left: 4px solid #ffc107;
               padding: 15px;
               border-radius: 5px;
               margin-bottom: 20px;
          }

          .warning-box p {
               margin: 0;
               color: #856404;
          }

          .contact-buttons {
               display: flex;
               gap: 10px;
               margin-top: 15px;
          }

          .contact-btn {
               flex: 1;
               padding: 10px;
               border: none;
               border-radius: 4px;
               font-weight: bold;
               cursor: pointer;
               text-decoration: none;
               text-align: center;
               display: block;
          }

          .phone-btn {
               background: #27ae60;
               color: white;
          }

          .phone-btn:hover {
               background: #229954;
          }

          .email-btn {
               background: #3498db;
               color: white;
          }

          .email-btn:hover {
               background: #2980b9;
          }

          /* Responsive Design */
          @media (max-width: 768px) {
               
               .detail-grid {
                    grid-template-columns: 1fr;
               }

               .checkout-grid {
                    grid-template-columns: 1fr;
               }

               .batch-card h2 {
                    font-size: 1.2em !important;
               }

               .batch-card table {
                    font-size: 0.9em;
               }

               .batch-card td,
               .batch-card th {
                    padding: 8px !important;
               }

               .batch-card a {
                    padding: 8px 12px !important;
                    font-size: 0.9em;
               }

               .fish-card {
                    width: calc(100% - 40px);
                    min-height: auto;
               }

               .fish-grid {
                    gap: 15px;
               }

               .fish-row>div {
                    grid-template-columns: 1fr !important;
                    gap: 10px !important;
               }

               .batch-card>div:last-child {
                    flex-direction: column;
                    align-items: stretch !important;
               }

               .batch-card>div:last-child>div {
                    width: 100%;
                    justify-content: center;
               }

               .checkout-grid {
                    grid-template-columns: 1fr;
               }

               .cart-item {
                    grid-template-columns: 1fr;
                    gap: 10px;
               }

               .price {
                    text-align: left;
               }

               .action-buttons {
                    flex-direction: column;
                    align-items: center;
               }

               .btn {
                    width: 200px;
                    text-align: center;
               }

               .summary-item {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 10px;
               }

               /* Order Detail Responsive */
               .order-header {
                    flex-direction: column;
                    gap: 15px;
                    align-items: flex-start;
               }

               .info-row {
                    flex-direction: column;
                    gap: 5px;
               }

               .info-value {
                    text-align: left;
               }

               .order-items-table {
                    font-size: 0.9em;
               }

               .order-items-table th,
               .order-items-table td {
                    padding: 8px;
               }
          }
     </style>
</head>

<body>
     <nav>
          <div class="container">
               <div>
                    <a href="{{ route('home') }}">Mājas</a>
                    <a href="{{ route('fish.index') }}">Zivis</a>
                    <a href="{{ route('batches.public') }}">Kūpinājumi</a>
               </div>
               <div>
                    @auth
                    @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">Admin Panelis</a>
                    @endif
                    <a href="{{ route('cart.index') }}">
                         🛒 Grozs
                         @if(auth()->user()->getCartCount() > 0)
                         <span style="background: #e74c3c; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.85em; margin-left: 5px;">
                              {{ auth()->user()->getCartCount() }}
                         </span>
                         @endif
                    </a>
                    <a href="{{ route('orders.index') }}">Mani pasūtījumi</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                         @csrf
                         <button type="submit" style="background:#e74c3c; padding:5px 10px;">
                              Iziet
                         </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}">Pieteikties</a>
                    <a href="{{ route('register') }}">Reģistrēties</a>
                    @endauth
               </div>
          </div>
     </nav>

     <div class="container">
          @if(session('success'))
          <div class="alert alert-success">
               {{ session('success') }}
          </div>
          @endif

          @if(session('error'))
          <div class="alert alert-error">
               {{ session('error') }}
          </div>
          @endif

          <!-- Main-->
          @yield('content')
     </div>
</body>

</html>