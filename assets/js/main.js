// Funnel data
        const funnelData = {
            current: {
                labels: ['Leads', 'Prospects', 'Qualified', 'Proposals', 'Closed Won'],
                values: [2847, 1847, 1247, 647, 247],
                conversionRates: [100, 64.9, 43.8, 22.7, 8.7],
                colors: ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#4f46e5']
            },
            last: {
                labels: ['Leads', 'Prospects', 'Qualified', 'Proposals', 'Closed Won'],
                values: [2456, 1567, 1047, 567, 187],
                conversionRates: [100, 63.8, 42.6, 23.1, 7.6],
                colors: ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#4f46e5']
            },
            quarter: {
                labels: ['Leads', 'Prospects', 'Qualified', 'Proposals', 'Closed Won'],
                values: [8234, 5234, 3434, 1834, 734],
                conversionRates: [100, 63.6, 41.7, 22.3, 8.9],
                colors: ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#4f46e5']
            },
            year: {
                labels: ['Leads', 'Prospects', 'Qualified', 'Proposals', 'Closed Won'],
                values: [32456, 22456, 14456, 8456, 3456],
                conversionRates: [100, 69.2, 44.5, 26.1, 10.6],
                colors: ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#4f46e5']
            }
        };

        // Initialize main funnel chart
        const funnelCtx = document.getElementById('funnelChart').getContext('2d');
        let funnelChart = new Chart(funnelCtx, {
            type: 'bar',
            data: {
                labels: funnelData.current.labels,
                datasets: [{
                    label: 'Number of Leads',
                    data: funnelData.current.values,
                    backgroundColor: funnelData.current.colors,
                    borderColor: funnelData.current.colors,
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                const value = context.parsed.x;
                                const rate = funnelData.current.conversionRates[index];
                                return [
                                    `Count: ${value.toLocaleString()}`,
                                    `Conversion Rate: ${rate}%`,
                                    `Drop-off: ${((funnelData.current.values[index-1] - value) / funnelData.current.values[index-1] * 100).toFixed(1)}%`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // Initialize conversion rate chart
        const conversionCtx = document.getElementById('conversionChart').getContext('2d');
        const conversionChart = new Chart(conversionCtx, {
            type: 'line',
            data: {
                labels: funnelData.current.labels,
                datasets: [{
                    label: 'Conversion Rate (%)',
                    data: funnelData.current.conversionRates,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#4f46e5',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Conversion Rate: ' + context.parsed.y + '%';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Initialize revenue chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: funnelData.current.labels.slice(1),
                datasets: [{
                    data: [1847*15000, 1247*25000, 647*35000, 247*45000],
                    backgroundColor: [
                        '#8b5cf6',
                        '#f59e0b', 
                        '#10b981',
                        '#4f46e5'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = '$' + (context.parsed / 1000000).toFixed(2) + 'M';
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Period button functionality
        document.querySelectorAll('.btn-funnel').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.btn-funnel').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                const period = this.dataset.period;
                const data = funnelData[period];
                
                // Update funnel chart
                funnelChart.data.labels = data.labels;
                funnelChart.data.datasets[0].data = data.values;
                funnelChart.data.datasets[0].backgroundColor = data.colors;
                funnelChart.update('active');
                
                // Update conversion chart
                conversionChart.data.labels = data.labels;
                conversionChart.data.datasets[0].data = data.conversionRates;
                conversionChart.update('active');
                
                // Update metrics
                updateMetrics(period);
            });
        });

        // Update metrics based on period
        function updateMetrics(period) {
            const metrics = {
                current: { conversion: '8.7%', dealSize: '$24,500', cycle: '42 days', revenue: '$6.05M' },
                last: { conversion: '7.6%', dealSize: '$22,100', cycle: '47 days', revenue: '$4.13M' },
                quarter: { conversion: '8.9%', dealSize: '$23,800', cycle: '44 days', revenue: '$17.47M' },
                year: { conversion: '10.6%', dealSize: '$26,200', cycle: '39 days', revenue: '$90.49M' }
            };

            const metricElements = {
                conversion: document.getElementById('overallConversion'),
                dealSize: document.getElementById('avgDealSize'),
                cycle: document.getElementById('salesCycle'),
                revenue: document.getElementById('revenue')
            };

            Object.keys(metrics[period]).forEach(key => {
                if (metricElements[key]) {
                    metricElements[key].textContent = metrics[period][key];
                    metricElements[key].parentElement.parentElement.classList.add('pulse');
                    setTimeout(() => {
                        metricElements[key].parentElement.parentElement.classList.remove('pulse');
                    }, 2000);
                }
            });
        }

        // Generate leads table data
        function generateLeadsData() {
            const names = ['John Smith', 'Sarah Johnson', 'Mike Williams', 'Emily Brown', 'David Davis', 'Lisa Anderson', 'Robert Wilson', 'Maria Garcia', 'James Martinez', 'Jennifer Taylor'];
            const companies = ['Tech Corp', 'Sales Inc', 'Marketing Pro', 'Data Systems', 'Cloud Solutions', 'Digital Agency', 'Startup Hub', 'Enterprise Co', 'Innovation Lab', 'Growth Partners'];
            const stages = ['lead', 'prospect', 'qualified', 'proposal', 'closed'];
            const stageBadges = {
                'lead': 'lead',
                'prospect': 'prospect', 
                'qualified': 'qualified',
                'proposal': 'proposal',
                'closed': 'closed'
            };
            
            let tableHTML = '';
            for (let i = 0; i < 10; i++) {
                const name = names[i];
                const company = companies[i];
                const stage = stages[Math.floor(Math.random() * stages.length)];
                const value = Math.floor(Math.random() * 50000) + 10000;
                const days = Math.floor(Math.random() * 60) + 5;
                const score = Math.floor(Math.random() * 40) + 60;
                
                tableHTML += `
                    <tr>
                        <td><strong>${name}</strong></td>
                        <td>${company}</td>
                        <td><span class="stage-badge ${stageBadges[stage]}">${stage.charAt(0).toUpperCase() + stage.slice(1)}</span></td>
                        <td>$${value.toLocaleString()}</td>
                        <td>${days}</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar ${score >= 80 ? 'bg-success' : score >= 60 ? 'bg-warning' : 'bg-danger'}" 
                                     role="progressbar" 
                                     style="width: ${score}%"
                                     aria-valuenow="${score}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    ${score}
                                </div>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewLeadDetails('${name}')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }
            
            document.getElementById('leadsTable').innerHTML = tableHTML;
        }

        // View lead details
        function viewLeadDetails(name) {
            const tooltip = document.getElementById('statsTooltip');
            tooltip.innerHTML = `<strong>${name}</strong><br>Click to view full profile`;
            tooltip.classList.add('active');
            
            setTimeout(() => {
                tooltip.classList.remove('active');
            }, 2000);
        }

        // Animate numbers
        function animateNumbers() {
            const counters = document.querySelectorAll('.stage-count');
            const speed = 200;

            counters.forEach(counter => {
                const animate = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText.replace(/,/g, '');
                    const increment = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment).toLocaleString();
                        setTimeout(animate, 10);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                };

                animate();
            });
        }

        // Add hover effects to stage cards
        document.querySelectorAll('.stage-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                const stageName = this.querySelector('.stage-name').textContent;
                const stageCount = this.querySelector('.stage-count').textContent;
                const tooltip = document.getElementById('statsTooltip');
                
                tooltip.innerHTML = `
                    <strong>${stageName}</strong><br>
                    Total: ${stageCount} leads<br>
                    Click for detailed analysis
                `;
                
                this.addEventListener('mousemove', (e) => {
                    tooltip.style.left = e.pageX + 10 + 'px';
                    tooltip.style.top = e.pageY - 30 + 'px';
                    tooltip.classList.add('active');
                });
            });

            card.addEventListener('mouseleave', function() {
                document.getElementById('statsTooltip').classList.remove('active');
            });

            card.addEventListener('click', function() {
                const stage = this.className.split(' ').find(cls => ['lead', 'prospect', 'qualified', 'proposal', 'closed'].includes(cls));
                filterTableByStage(stage);
            });
        });

        // Filter table by stage
        function filterTableByStage(stage) {
            const rows = document.querySelectorAll('#leadsTable tr');
            rows.forEach(row => {
                const badge = row.querySelector('.stage-badge');
                if (badge && badge.classList.contains(stage)) {
                    row.style.display = '';
                    row.style.animation = 'fadeIn 0.5s ease-in';
                } else if (badge) {
                    row.style.display = 'none';
                }
            });
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize navigation
            initNavigation();
            
            // Generate initial data
            generateLeadsData();
            
            // Animate numbers on load
            setTimeout(animateNumbers, 500);
            
            // Add staggered animations
            document.querySelectorAll('.fade-in').forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(30px)';
                    element.style.animation = `fadeIn 0.8s ease-in forwards`;
                }, index * 150);
            });

            // Simulate real-time updates
            setInterval(() => {
                // Update a random stage count
                const stageCards = document.querySelectorAll('.stage-count');
                const randomCard = stageCards[Math.floor(Math.random() * stageCards.length)];
                const currentValue = parseInt(randomCard.textContent.replace(/,/g, ''));
                const change = Math.floor(Math.random() * 10) - 5;
                const newValue = Math.max(0, currentValue + change);
                
                randomCard.setAttribute('data-target', newValue);
                randomCard.textContent = newValue.toLocaleString();
                randomCard.parentElement.classList.add('pulse');
                
                setTimeout(() => {
                    randomCard.parentElement.classList.remove('pulse');
                }, 2000);
            }, 8000);
        });

        // Navigation functionality
        function initNavigation() {
            // Handle navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Active navigation state
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Close mobile menu if open
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        const navbarToggler = document.querySelector('.navbar-toggler');
                        navbarToggler.click();
                    }
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('href');
                    if (target !== '#') {
                        const element = document.querySelector(target);
                        if (element) {
                            const offsetTop = element.offsetTop - 100; // Account for fixed navbar
                            window.scrollTo({
                                top: offsetTop,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key >= '1' && e.key <= '4') {
                const buttons = document.querySelectorAll('.btn-funnel');
                const index = parseInt(e.key) - 1;
                if (buttons[index]) {
                    buttons[index].click();
                }
            }
        });