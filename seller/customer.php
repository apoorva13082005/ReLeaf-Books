<?php include '../header.php'; ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookCycle - Sustainable Student Book Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
       :root {
            --primary: #2e8b57;
            --primary-light: #3cb371;
            --primary-dark: #1d6e42;
            --secondary: #8a5a44;
            --accent: #ff6b35;
            --light: #f8f9fa;
            --dark: #343a40;
            --light-bg: #f9f6f1;
        } --light: #FFFFFF;
        
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        
        
       
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        
        .search-container {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .book-card {
            transition: transform 0.3s;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .price-cap-badge {
            background-color: var(--accent);
            color: white;
            font-weight: 600;
        }
        
        .eco-badge {
            background-color: var(--primary);
            color: white;
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            display: inline-block;
            margin-right: 0.3rem;
            margin-bottom: 0.3rem;
        }
        
        .verified-badge {
            color: #17a2b8;
            font-weight: 600;
        }
        
        .wishlist-btn {
            color: #dc3545;
            border: none;
            background: transparent;
            font-size: 1.2rem;
        }
        
        .wishlist-btn:hover {
            color: #bd2130;
        }
        
        .feature-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .eco-dashboard {
            background-color: #e8f5e9;
            border-radius: 10px;
            padding: 1.5rem;
        }
        
        .progress {
            height: 8px;
            margin-bottom: 0.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: #267445;
            border-color: #267445;
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .community-card {
            transition: all 0.3s;
        }
        
        .community-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .notes-resources {
            background-color: #f0f8ff;
            border-left: 4px solid var(--primary);
        }
        
        .bundle-card {
            border: 2px solid var(--primary);
            border-radius: 10px;
        }
        
        .seller-rating {
            color: #FFD700;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary);
            font-weight: 600;
            border-bottom: 3px solid var(--primary);
        }
        
        .order-timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .order-timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #dee2e6;
        }
        
        .timeline-step {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .timeline-step::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary);
        }
        
        .recommendation-card {
            transition: all 0.3s;
            height: 100%;
        }
        
        .recommendation-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <!-- Hero Section with Search -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Find Your Next Book, Save the Planet</h1>
            <p class="lead mb-4">Buy and sell academic books at fair prices while reducing your environmental impact</p>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="search-container">
                        <h4 class="mb-3">What book are you looking for?</h4>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg" id="searchInput" placeholder="Search by title, author, ISBN, or syllabus (e.g., B.Tech 2nd Year CSE Semester 3)">
                            <button class="btn btn-primary btn-lg" type="button" id="searchButton">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                        <div class="form-text mt-2">
                            <i class="fas fa-lightbulb me-1"></i> Try: "UPSC GS Paper 1" or "C++ by Balagurusamy"
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div class="loading" id="loadingIndicator">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Loading books...</p>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Filters</h5>
                    </div>
                    <div class="card-body">
                        <h6>Category</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cat1" checked>
                            <label class="form-check-label" for="cat1">Academic</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cat2">
                            <label class="form-check-label" for="cat2">Novels</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cat3">
                            <label class="form-check-label" for="cat3">Exam Prep</label>
                        </div>
                        
                        <hr>
                        
                        <h6>Condition</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cond1">
                            <label class="form-check-label" for="cond1">New-like</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cond2" checked>
                            <label class="form-check-label" for="cond2">Good</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cond3">
                            <label class="form-check-label" for="cond3">Acceptable</label>
                        </div>
                        
                        <hr>
                        
                        <h6>Seller Type</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="verified">
                            <label class="form-check-label" for="verified">Verified Sellers Only</label>
                        </div>
                        
                        <hr>
                        
                        <button class="btn btn-primary w-100" id="applyFilters">Apply Filters</button>
                    </div>
                </div>
                
                <!-- Eco Impact Dashboard -->
                <div class="eco-dashboard mb-4">
                    <h5 class="text-center mb-3">Your Eco Impact</h5>
                    
                    <div class="d-flex justify-content-between mb-1">
                        <span>CO₂ Saved</span>
                        <span id="co2Saved">15 kg</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-1">
                        <span>Water Saved</span>
                        <span id="waterSaved">2,500 L</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 60%"></div>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-1">
                        <span>Trees Saved</span>
                        <span id="treesSaved">0.3</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 30%"></div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <small>Based on <span id="booksPurchased">5</span> book purchases</small>
                    </div>
                </div>
                
                <!-- Community Access -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Communities</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-graduation-cap me-2"></i> UPSC Preparation</span>
                                <span class="badge bg-primary rounded-pill">1.2k</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-laptop-code me-2"></i> GATE Computer Science</span>
                                <span class="badge bg-primary rounded-pill">845</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-book-medical me-2"></i> NEET UG</span>
                                <span class="badge bg-primary rounded-pill">1.5k</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-book-reader me-2"></i> Fiction Novels</span>
                                <span class="badge bg-primary rounded-pill">978</span>
                            </li>
                            <li class="list-group-item text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary">View All Communities</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Book Listings -->
            <div class="col-lg-9">
                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="books-tab" data-bs-toggle="tab" data-bs-target="#books" type="button" role="tab">Books</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bundles-tab" data-bs-toggle="tab" data-bs-target="#bundles" type="button" role="tab">Semester Bundles</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">Notes & Resources</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    <!-- Books Tab -->
                    <div class="tab-pane fade show active" id="books" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>Available Books</h3>
                            <div>
                                <select class="form-select form-select-sm" id="sortSelect">
                                    <option value="newest">Sort by: Newest</option>
                                    <option value="priceLow">Sort by: Price Low to High</option>
                                    <option value="priceHigh">Sort by: Price High to Low</option>
                                    <option value="relevance">Sort by: Relevance</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row" id="booksContainer">
                            <!-- Books will be dynamically loaded here -->
                        </div>
                        
                        <!-- Requested Books Section -->
                        <div class="mt-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Recently Requested by Others</h4>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            
                            <div class="row" id="requestedBooksContainer">
                                <!-- Requested books will be dynamically loaded here -->
                            </div>
                        </div>
                        
                        <!-- Personalized Recommendations -->
                        <div class="mt-5">
                            <h4 class="mb-4">Recommended For You</h4>
                            <div class="row" id="recommendationsContainer">
                                <!-- Recommendations will be dynamically loaded here -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bundles Tab -->
                    <div class="tab-pane fade" id="bundles" role="tabpanel">
                        <h3 class="mb-4">Semester Bundles</h3>
                        
                        <div class="row" id="bundlesContainer">
                            <!-- Bundles will be dynamically loaded here -->
                        </div>
                    </div>
                    
                    <!-- Notes & Resources Tab -->
                    <div class="tab-pane fade" id="notes" role="tabpanel">
                        <h3 class="mb-4">Community Notes & Resources</h3>
                        
                        <div class="notes-resources p-4 mb-4">
                            <h5><i class="fas fa-info-circle me-2"></i> Sharing Knowledge Helps Everyone</h5>
                            <p class="mb-0">Upload your notes, guides, and previous year papers to help other students and earn community points!</p>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-sticky-note me-2"></i> Upload Notes</h5>
                                        <p class="card-text">Share your handwritten or digital notes with the community.</p>
                                        <button class="btn btn-outline-primary"><i class="fas fa-upload me-1"></i> Upload Now</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-file-pdf me-2"></i> Previous Year Papers</h5>
                                        <p class="card-text">Access question papers from previous years to help with exam preparation.</p>
                                        <button class="btn btn-outline-primary"><i class="fas fa-search me-1"></i> Browse Papers</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="mb-3">Popular Resources</h4>
                        
                        <div class="row" id="resourcesContainer">
                            <!-- Resources will be dynamically loaded here -->
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-primary">Browse All Resources</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Book Modal -->
    <div class="modal fade" id="requestModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request a Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Can't find the book you're looking for? Let us know and we'll notify you when it becomes available!</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Book Title</label>
                        <input type="text" class="form-control" id="requestTitle" placeholder="Enter book title">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <input type="text" class="form-control" id="requestAuthor" placeholder="Enter author name">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Edition (if specific)</label>
                        <input type="text" class="form-control" id="requestEdition" placeholder="e.g., 5th Edition">
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notifyMatch">
                        <label class="form-check-label" for="notifyMatch">Notify me when a seller lists this book</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitRequest">Submit Request</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Smart Return Policy Modal -->
    <div class="modal fade" id="returnPolicyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Smart Return Policy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Our return policy is designed to protect both buyers and sellers while ensuring fairness.
                    </div>
                    
                    <h6>Return Conditions</h6>
                    <p>Returns are allowed only in the following cases:</p>
                    <ul>
                        <li>Wrong edition or ISBN</li>
                        <li>Missing pages or content</li>
                        <li>Damage not mentioned in the listing</li>
                    </ul>
                    
                    <h6>How It Works</h6>
                    <ol>
                        <li>Seller may request a small refundable deposit (to ensure honesty)</li>
                        <li>Platform holds payment until buyer confirms book condition</li>
                        <li>Returns must be requested within 3 days of delivery</li>
                        <li>Photo/video proof required for dispute resolution</li>
                    </ol>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i> Note: Returns are not accepted for minor issues like highlighting, notes, or slight wear that was mentioned in the listing.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Tracking Modal -->
    <div class="modal fade" id="orderTrackingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order #BC123456 Tracking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="order-timeline">
                        <div class="timeline-step">
                            <h6>Order Placed</h6>
                            <p class="text-muted small mb-0">June 12, 2023 - 10:30 AM</p>
                            <p class="small">Your order has been received</p>
                        </div>
                        <div class="timeline-step">
                            <h6>Seller Confirmed</h6>
                            <p class="text-muted small mb-0">June 12, 2023 - 11:45 AM</p>
                            <p class="small">Seller has confirmed the order</p>
                        </div>
                        <div class="timeline-step">
                            <h6>Book Shipped</h6>
                            <p class="text-muted small mb-0">June 13, 2023 - 02:15 PM</p>
                            <p class="small">Your book has been shipped</p>
                        </div>
                        <div class="timeline-step">
                            <h6>In Transit</h6>
                            <p class="text-muted small mb-0">Expected delivery: June 15, 2023</p>
                            <p class="small">Your book is on the way</p>
                        </div>
                        <div class="timeline-step">
                            <h6>Out for Delivery</h6>
                            <p class="text-muted small mb-0">Expected today</p>
                            <p class="small">Your book will be delivered soon</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#confirmReceiptModal">
                            Confirm Receipt & Release Payment
                        </button>
                        <p class="small text-muted mt-2">Please confirm only after verifying the book condition</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // API endpoints (would be replaced with actual endpoints in production)
        const API_ENDPOINTS = {
            BOOKS: '/api/books',
            REQUESTS: '/api/requests',
            BUNDLES: '/api/bundles',
            RESOURCES: '/api/resources',
            RECOMMENDATIONS: '/api/recommendations',
            ORDERS: '/api/orders'
        };

        // Sample data (would be replaced with actual API calls in production)
        const sampleBooks = [
            {
                id: 1,
                title: "Introduction to C++",
                author: "E. Balagurusamy",
                edition: "7th Edition",
                condition: "Good",
                price: 299,
                originalPrice: 650,
                maxPrice: 350,
                co2Saved: 1,
                waterSaved: 200,
                sellerVerified: true,
                rating: 4.5,
                reviews: 128,
                image: "https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                outOfStock: false
            },
            {
                id: 2,
                title: "Python Crash Course",
                author: "Eric Matthes",
                edition: "2nd Edition",
                condition: "New-like",
                price: 425,
                originalPrice: 899,
                maxPrice: 450,
                co2Saved: 1.2,
                waterSaved: 250,
                sellerVerified: false,
                rating: 4.0,
                reviews: 64,
                image: "https://images.unsplash.com/photo-1532012197267-da84d127e765?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                outOfStock: false
            },
            {
                id: 3,
                title: "Data Structures & Algorithms",
                author: "Narasimha Karumanchi",
                edition: "Latest Edition",
                condition: "Good",
                price: 499,
                originalPrice: 799,
                maxPrice: 550,
                co2Saved: 1.5,
                waterSaved: 300,
                sellerVerified: true,
                rating: 4.9,
                reviews: 217,
                image: "https://images.unsplash.com/photo-1512820790803-83ca734da794?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                outOfStock: true
            }
        ];

        const sampleRequests = [
            {
                id: 1,
                title: "Introduction to Algorithms",
                author: "Cormen",
                requests: 12,
                institutions: "IIT Delhi, BITS Pilani, VIT"
            },
            {
                id: 2,
                title: "Concept of Physics",
                author: "HC Verma",
                requests: 28,
                institutions: "DU, IP University, Amity"
            }
        ];

        const sampleBundles = [
            {
                id: 1,
                title: "B.Tech CSE Semester 3 Bundle",
                books: ["Data Structures & Algorithms", "Database Management Systems", "Computer Organization", "Discrete Mathematics", "Python Programming"],
                price: 1999,
                originalPrice: 2850,
                savings: 851
            },
            {
                id: 2,
                title: "B.Com Semester 2 Bundle",
                books: ["Business Mathematics", "Financial Accounting", "Business Law", "Microeconomics", "Business Communication"],
                price: 1599,
                originalPrice: 2250,
                savings: 651
            }
        ];

        const sampleResources = [
            {
                id: 1,
                title: "Data Structures Complete Notes",
                category: "Computer Science",
                description: "Comprehensive notes covering all important topics with diagrams and examples.",
                downloads: 128,
                rating: 4.8,
                date: "2 days ago"
            },
            {
                id: 2,
                title: "Indian Polity Mind Maps",
                category: "UPSC",
                description: "Visual mind maps covering the entire Indian Polity syllabus for quick revision.",
                downloads: 254,
                rating: 4.9,
                date: "1 week ago"
            }
        ];

        const sampleRecommendations = [
            {
                id: 1,
                title: "Data Science with Python",
                author: "John Smith",
                price: 375,
                rating: 4.7,
                image: "https://images.unsplash.com/photo-1553729459-efe14ef6055d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
            },
            {
                id: 2,
                title: "Machine Learning Fundamentals",
                author: "Sarah Johnson",
                price: 499,
                rating: 4.8,
                image: "https://images.unsplash.com/photo-1558901357-ca41e027e43a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
            }
        ];

        // DOM elements
        const booksContainer = document.getElementById('booksContainer');
        const requestedBooksContainer = document.getElementById('requestedBooksContainer');
        const bundlesContainer = document.getElementById('bundlesContainer');
        const resourcesContainer = document.getElementById('resourcesContainer');
        const recommendationsContainer = document.getElementById('recommendationsContainer');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const sortSelect = document.getElementById('sortSelect');
        const applyFilters = document.getElementById('applyFilters');
        const submitRequest = document.getElementById('submitRequest');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const toast = document.querySelector('.toast');

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            loadBooks();
            loadRequestedBooks();
            loadBundles();
            loadResources();
            loadRecommendations();
            setupEventListeners();
        });

        // Set up event listeners
        function setupEventListeners() {
            searchButton.addEventListener('click', handleSearch);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    handleSearch();
                }
            });
            sortSelect.addEventListener('change', handleSort);
            applyFilters.addEventListener('click', handleFilter);
            submitRequest.addEventListener('click', handleBookRequest);
        }

        // Show loading indicator
        function showLoading() {
            loadingIndicator.style.display = 'block';
        }

        // Hide loading indicator
        function hideLoading() {
            loadingIndicator.style.display = 'none';
        }

        // Show toast notification
        function showToast(message, type = 'success') {
            const toastBody = toast.querySelector('.toast-body');
            toastBody.textContent = message;
            
            if (type === 'error') {
                toast.querySelector('.toast-header').classList.add('bg-danger', 'text-white');
            } else {
                toast.querySelector('.toast-header').classList.remove('bg-danger', 'text-white');
            }
            
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        }

        // Handle search
        function handleSearch() {
            const query = searchInput.value.trim();
            if (query) {
                showLoading();
                // Simulate API call delay
                setTimeout(() => {
                    // In a real application, this would be an API call
                    const filteredBooks = sampleBooks.filter(book => 
                        book.title.toLowerCase().includes(query.toLowerCase()) || 
                        book.author.toLowerCase().includes(query.toLowerCase())
                    );
                    renderBooks(filteredBooks);
                    hideLoading();
                    showToast(`Found ${filteredBooks.length} books matching "${query}"`);
                }, 1000);
            }
        }

        // Handle sort
        function handleSort() {
            const sortBy = sortSelect.value;
            showLoading();
            // Simulate API call delay
            setTimeout(() => {
                let sortedBooks = [...sampleBooks];
                
                switch(sortBy) {
                    case 'priceLow':
                        sortedBooks.sort((a, b) => a.price - b.price);
                        break;
                    case 'priceHigh':
                        sortedBooks.sort((a, b) => b.price - a.price);
                        break;
                    case 'newest':
                    default:
                        // Default sort (by id as a proxy for newest)
                        sortedBooks.sort((a, b) => b.id - a.id);
                        break;
                }
                
                renderBooks(sortedBooks);
                hideLoading();
            }, 500);
        }

        // Handle filter
        function handleFilter() {
            const verifiedOnly = document.getElementById('verified').checked;
            showLoading();
            // Simulate API call delay
            setTimeout(() => {
                let filteredBooks = verifiedOnly 
                    ? sampleBooks.filter(book => book.sellerVerified) 
                    : sampleBooks;
                
                renderBooks(filteredBooks);
                hideLoading();
                showToast(`Filter applied: ${verifiedOnly ? 'Verified sellers only' : 'All sellers'}`);
            }, 500);
        }

        // Handle book request
        function handleBookRequest() {
            const title = document.getElementById('requestTitle').value.trim();
            const author = document.getElementById('requestAuthor').value.trim();
            const edition = document.getElementById('requestEdition').value.trim();
            const notify = document.getElementById('notifyMatch').checked;
            
            if (!title) {
                showToast('Please enter a book title', 'error');
                return;
            }
            
            // Simulate API call
            showLoading();
            setTimeout(() => {
                // In a real application, this would be an API call to submit the request
                hideLoading();
                bootstrap.Modal.getInstance(document.getElementById('requestModal')).hide();
                showToast(`Your request for "${title}" has been submitted!${notify ? ' You will be notified when available.' : ''}`);
                
                // Clear the form
                document.getElementById('requestTitle').value = '';
                document.getElementById('requestAuthor').value = '';
                document.getElementById('requestEdition').value = '';
                document.getElementById('notifyMatch').checked = false;
            }, 1000);
        }

        // Load books
        function loadBooks() {
            showLoading();
            // Simulate API call delay
            setTimeout(() => {
                renderBooks(sampleBooks);
                hideLoading();
            }, 1000);
        }

        // Render books
        function renderBooks(books) {
            booksContainer.innerHTML = '';
            
            if (books.length === 0) {
                booksContainer.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                        <h4>No books found</h4>
                        <p>Try adjusting your search or filters</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestModal">
                            Request a Book
                        </button>
                    </div>
                `;
                return;
            }
            
            books.forEach(book => {
                const bookCard = document.createElement('div');
                bookCard.className = 'col-md-6 col-lg-4 mb-4';
                bookCard.innerHTML = `
                    <div class="card book-card">
                        <div class="position-relative">
                            <img src="${book.image}" class="card-img-top" alt="${book.title}" style="height: 200px; object-fit: cover;">
                            ${book.outOfStock ? 
                                `<span class="position-absolute top-0 start-0 m-2 badge bg-danger">Out of Stock</span>` : 
                                `<span class="position-absolute top-0 end-0 m-2 price-cap-badge">Max: ₹${book.maxPrice}</span>`
                            }
                            <button class="btn wishlist-btn position-absolute bottom-0 end-0 m-2">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">${book.title}</h5>
                            <p class="card-text mb-1">by ${book.author}</p>
                            <p class="card-text mb-2"><small class="text-muted">${book.edition} · ${book.condition} Condition</small></p>
                            
                            <div class="mb-2">
                                <span class="eco-badge"><i class="fas fa-cloud"></i> ${book.co2Saved} kg CO₂ saved</span>
                                <span class="eco-badge"><i class="fas fa-tint"></i> ${book.waterSaved}L water saved</span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="fw-bold text-primary">₹${book.price}</span>
                                    ${book.originalPrice ? `<span class="text-decoration-line-through text-muted ms-1">₹${book.originalPrice}</span>` : ''}
                                </div>
                                <div>
                                    ${book.sellerVerified ? 
                                        `<span class="verified-badge"><i class="fas fa-check-circle"></i> Verified Seller</span>` : 
                                        `<span class="text-muted"><i class="fas fa-user"></i> Regular Seller</span>`
                                    }
                                </div>
                            </div>
                            
                            <div class="mt-2">
                                <span class="seller-rating">
                                    ${generateStarRating(book.rating)}
                                    ${book.rating}
                                </span>
                                <small class="text-muted">(${book.reviews} reviews)</small>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            ${book.outOfStock ? 
                                `<button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#requestModal">
                                    <i class="fas fa-bell me-1"></i> Request This Book
                                </button>` : 
                                `<button class="btn btn-primary w-100">Add to Cart</button>`
                            }
                        </div>
                    </div>
                `;
                booksContainer.appendChild(bookCard);
            });
            
            // Add wishlist functionality
            document.querySelectorAll('.wishlist-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        showToast('Added to wishlist');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        showToast('Removed from wishlist');
                    }
                });
            });
        }

        // Generate star rating HTML
        function generateStarRating(rating) {
            let stars = '';
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            
            for (let i = 0; i < fullStars; i++) {
                stars += '<i class="fas fa-star"></i>';
            }
            
            if (hasHalfStar) {
                stars += '<i class="fas fa-star-half-alt"></i>';
            }
            
            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) {
                stars += '<i class="far fa-star"></i>';
            }
            
            return stars;
        }

        // Load requested books
        function loadRequestedBooks() {
            // Simulate API call delay
            setTimeout(() => {
                renderRequestedBooks(sampleRequests);
            }, 500);
        }

        // Render requested books
        function renderRequestedBooks(requests) {
            requestedBooksContainer.innerHTML = '';
            
            requests.forEach(request => {
                const col = document.createElement('div');
                col.className = 'col-md-6';
                col.innerHTML = `
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title">"${request.title}" by ${request.author}</h6>
                                <span class="badge bg-info">${request.requests} requests</span>
                            </div>
                            <p class="card-text mb-1"><small>Requested by students from ${request.institutions}</small></p>
                            <button class="btn btn-sm btn-outline-primary mt-2">I have this book</button>
                        </div>
                    </div>
                `;
                requestedBooksContainer.appendChild(col);
            });
        }

        // Load bundles
        function loadBundles() {
            // Simulate API call delay
            setTimeout(() => {
                renderBundles(sampleBundles);
            }, 500);
        }

        // Render bundles
        function renderBundles(bundles) {
            bundlesContainer.innerHTML = '';
            
            bundles.forEach(bundle => {
                const col = document.createElement('div');
                col.className = 'col-md-6 mb-4';
                col.innerHTML = `
                    <div class="card bundle-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">${bundle.title}</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush mb-3">
                                ${bundle.books.map(book => `<li class="list-group-item">${book}</li>`).join('')}
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold text-primary fs-4">₹${bundle.price}</span>
                                    <span class="text-decoration-line-through text-muted ms-2">₹${bundle.originalPrice}</span>
                                </div>
                                <span class="badge bg-success">Save ₹${bundle.savings}</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary w-100">View Bundle Details</button>
                        </div>
                    </div>
                `;
                bundlesContainer.appendChild(col);
            });
        }

        // Load resources
        function loadResources() {
            // Simulate API call delay
            setTimeout(() => {
                renderResources(sampleResources);
            }, 500);
        }

        // Render resources
        function renderResources(resources) {
            resourcesContainer.innerHTML = '';
            
            resources.forEach(resource => {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-4';
                col.innerHTML = `
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-info">${resource.category}</span>
                                <small class="text-muted">${resource.date}</small>
                            </div>
                            <h6 class="card-title">${resource.title}</h6>
                            <p class="card-text small">${resource.description}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small><i class="fas fa-download me-1"></i> ${resource.downloads} downloads</small>
                                <span class="seller-rating small">
                                    ${generateStarRating(resource.rating)}
                                    ${resource.rating}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-outline-primary w-100">Download</button>
                        </div>
                    </div>
                `;
                resourcesContainer.appendChild(col);
            });
        }

        // Load recommendations
        function loadRecommendations() {
            // Simulate API call delay
            setTimeout(() => {
                renderRecommendations(sampleRecommendations);
            }, 500);
        }

        // Render recommendations
        function renderRecommendations(recommendations) {
            recommendationsContainer.innerHTML = '';
            
            recommendations.forEach(book => {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-4';
                col.innerHTML = `
                    <div class="card recommendation-card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="${book.image}" alt="${book.title}" style="height: 150px; object-fit: cover;">
                            </div>
                            <h6 class="mt-3">${book.title}</h6>
                            <p class="text-muted small">by ${book.author}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">₹${book.price}</span>
                                <span class="seller-rating small">
                                    ${generateStarRating(book.rating)}
                                    ${book.rating}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
                recommendationsContainer.appendChild(col);
            });
        }
    </script>
</body>
</html>