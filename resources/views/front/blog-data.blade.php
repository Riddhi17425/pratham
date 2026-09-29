<?php
// Shared blog data used by blog.php and blog-detail.php
$blog_featured = [
    "title" => "Choosing the Right Filtration System for Your Industrial Process",
    "date" => "April 30, 2024",
    "excerpt" => "From ETP to RO to food-grade processing, every application calls for a different filtration approach. Here's how to match the right cartridge, housing, and micron rating to your process.",
    "image" => "img/figma/blog/blog-featured.jpg",
];

$blog_posts = [
    [
        "title" => "How Hydro Pneumatic Tanks Improve Flow",
        "date" => "April 30, 2024",
        "image" => "img/figma/article2.jpg",
        "excerpt" => "Hydro pneumatic tanks smooth out pressure fluctuations and reduce pump cycling. Here's how they keep water systems running efficiently.",
    ],
    [
        "title" => "Why Anti-Scalants Matter in RO Plants",
        "date" => "April 30, 2024",
        "image" => "img/figma/article3.jpg",
        "excerpt" => "Scale build-up is one of the most common causes of RO membrane failure. Anti-scalant dosing protects your system and extends membrane life.",
    ],
    [
        "title" => "A Guide to Membrane Pressure Vessels",
        "date" => "April 30, 2024",
        "image" => "img/figma/article4.jpg",
        "excerpt" => "Pressure vessels house and protect RO membranes under demanding operating conditions. Here's what to check before you specify one.",
    ],
    [
        "title" => "Why Bag Filters Are Essential for Dust Control in the Steel Industry",
        "date" => "April 22, 2024",
        "image" => "img/figma/blog/blog-bagfilter-steel.jpg",
        "excerpt" => "Steel manufacturing generates significant particulate matter. Bag filters remain one of the most reliable, cost-effective ways to control it.",
    ],
    [
        "title" => "Understanding Micron Ratings in Cartridge Filters",
        "date" => "April 15, 2024",
        "image" => "img/figma/cartridges.jpg",
        "excerpt" => "Nominal vs absolute micron ratings can make or break your filtration outcome. Here's what the numbers actually mean.",
    ],
    [
        "title" => "ETP vs STP: What's the Difference?",
        "date" => "April 08, 2024",
        "image" => "img/figma/filter-large.jpg",
        "excerpt" => "Effluent and sewage treatment plants solve different problems. Understanding the distinction helps you choose the right filtration setup.",
    ],
    [
        "title" => "5 Signs Your Filter Housing Needs Replacement",
        "date" => "March 28, 2024",
        "image" => "img/figma/plastic-filter-housing.jpg",
        "excerpt" => "Cracked seals, pressure drops, and visible wear are all warning signs. Catching them early prevents costly downtime.",
    ],
    [
        "title" => "Stainless Steel vs UPVC Housings: Which to Choose?",
        "date" => "March 20, 2024",
        "image" => "img/figma/ss-filter-cartridge.jpg",
        "excerpt" => "Both materials have their place. Here's how to decide between SS and UPVC housings based on your process chemistry and flow rate.",
    ],
];

// Each post body is a list of blocks. A block is either:
//   ["p", "paragraph text"]  - a paragraph
//   ["h", "heading text"]    - a small section heading
// The first "p" block is used as the intro paragraph (shown before the hero image);
// everything after that renders below the image, matching the Figma article layout.
$blog_body = [
    "Choosing the Right Filtration System for Your Industrial Process" => [
        ["p", "Every industrial filtration challenge starts with the same question: what exactly are you trying to remove, and at what flow rate? Getting this wrong at the specification stage is the single biggest cause of underperforming filtration systems."],
        ["h", "Matching Filtration to Your Application"],
        ["p", "For ETP and STP applications, the priority is usually robust pre-filtration ahead of biological or chemical treatment stages. Basket strainers and bag filters handle the bulk of suspended solids before finer cartridge filtration takes over."],
        ["p", "RO and desalination systems demand a different approach entirely. Here, protecting the membrane is paramount — which means sediment pre-filters, anti-scalant dosing, and correctly rated cartridge housings upstream of the membrane stage."],
        ["h", "Getting the Specification Right"],
        ["p", "Food, beverage, and pharma applications add another layer of consideration: material compatibility and hygiene standards. NSF and PED certified components aren't optional in these settings — they're the baseline."],
        ["p", "The right answer is almost never a single product. It's a system — sized, sequenced, and specified around your actual water chemistry and throughput, not a generic catalogue selection."],
    ],
    "Why Bag Filters Are Essential for Dust Control in the Steel Industry" => [
        ["p", "Steel manufacturing is one of the most particulate-intensive industrial processes there is. From furnace off-gas to material handling, dust generation happens at nearly every stage of production."],
        ["h", "Why Bag Filters Work So Well"],
        ["p", "Bag filters remain the workhorse of dust control in this environment for good reason: they offer a large filtration surface area in a compact footprint, and they're straightforward to maintain even in high-volume, continuous-duty settings."],
        ["h", "Built for Demanding Conditions"],
        ["p", "Pratham's BP and RSB series bag filters are built specifically for these demanding conditions — non-woven needle felts with glazed PP finishes for the BP series, and multi-layer RSB filters with rubber-collar sealing that prevents bypass, a common failure point in lower-quality bag filter systems."],
        ["p", "For steel plants managing continuous emissions compliance, filter selection isn't just an operational decision — it's a regulatory one. Getting the micron rating and dirt-holding capacity right reduces both downtime and compliance risk."],
    ],
];
