<!DOCTYPE html>
<html lang="en_US">

<head>
    <title>Larametrics Dashboard</title>
    <link href="/vendor/larametrics/app.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-500 antialiased">
    <div class="absolute left-2 top-2 opacity-80">
        <svg width="32" height="32" viewBox="0 0 104 104" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="20" height="104" fill="#3B82F6" />
            <rect width="20" height="104" fill="url(#paint0_linear_2_4)" fill-opacity="0.2" />
            <rect x="104" width="20" height="76" transform="rotate(90 104 0)" fill="#3B82F6" />
            <rect x="104" width="20" height="76" transform="rotate(90 104 0)" fill="url(#paint1_linear_2_4)"
                fill-opacity="0.2" />
            <rect x="76" y="84" width="20" height="76" transform="rotate(90 76 84)" fill="#3B82F6" />
            <rect x="76" y="84" width="20" height="76" transform="rotate(90 76 84)" fill="url(#paint2_linear_2_4)"
                fill-opacity="0.2" />
            <rect x="28" width="20" height="76" fill="#3B82F6" />
            <rect x="28" width="20" height="76" fill="url(#paint3_linear_2_4)" fill-opacity="0.2" />
            <rect x="56" width="20" height="76" fill="#3B82F6" />
            <rect x="56" width="20" height="76" fill="url(#paint4_linear_2_4)" fill-opacity="0.2" />
            <rect x="84" width="20" height="76" fill="#3B82F6" />
            <rect x="84" width="20" height="76" fill="url(#paint5_linear_2_4)" fill-opacity="0.2" />
            <rect x="84" y="84" width="20" height="20" fill="#3B82F6" />
            <rect x="84" y="84" width="20" height="20" fill="url(#paint6_linear_2_4)" fill-opacity="0.2" />
            <defs>
                <linearGradient id="paint0_linear_2_4" x1="0.192308" y1="0.5" x2="-29.4225" y2="26.4699"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="white" />
                    <stop offset="1" stop-opacity="0.5" />
                </linearGradient>
                <linearGradient id="paint1_linear_2_4" x1="104.192" y1="0.365384" x2="82.7216" y2="26.1302"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="white" />
                    <stop offset="1" stop-opacity="0.5" />
                </linearGradient>
                <linearGradient id="paint2_linear_2_4" x1="76.1923" y1="84.3654" x2="54.7216" y2="110.13"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="white" />
                    <stop offset="1" stop-opacity="0.5" />
                </linearGradient>
                <linearGradient id="paint3_linear_2_4" x1="28.1923" y1="0.365384" x2="6.72163" y2="26.1302"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="white" />
                    <stop offset="1" stop-opacity="0.5" />
                </linearGradient>
                <linearGradient id="paint4_linear_2_4" x1="56.1923" y1="0.365384" x2="34.7216" y2="26.1302"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="white" />
                    <stop offset="1" stop-opacity="0.5" />
                </linearGradient>
                <linearGradient id="paint5_linear_2_4" x1="84.1923" y1="0.365384" x2="62.7216" y2="26.1302"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="white" />
                    <stop offset="1" stop-opacity="0.5" />
                </linearGradient>
                <linearGradient id="paint6_linear_2_4" x1="84.1923" y1="84.0962" x2="81.7885" y2="95.0577"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="white" />
                    <stop offset="1" stop-opacity="0.5" />
                </linearGradient>
            </defs>
        </svg>
    </div>
    <div class="max-w-screen-lg mx-auto py-8">
        <header>
            <h1 class="text-2xl font-semibold text-gray-900 mb-0">Overview</h1>
        </header>
        <main>
            <div class="rounded bg-white w-full px-8 py-4 shadow mt-4 flex justify-between">
                <div>
                    <h5 class="mb-1">Requests</h5>
                    <h3 class="text-xl font-semibold text-gray-900">1,259</h3>
                    <div>
                        <span class="inline-block mr-1 text-sm font-semibold text-green-600">+3.5%</span>
                        <span class="inline-block text-sm text-gray-400">Avg Daily: 139</span>
                    </div>
                </div>
                <div>
                    <h5 class="mb-1">Unique Requests</h5>
                    <h3 class="text-xl font-semibold text-gray-900">521</h3>
                    <div>
                        <span class="inline-block mr-1 text-sm font-semibold text-green-600">+17.2%</span>
                        <span class="inline-block text-sm text-gray-400">Avg Daily: 17</span>
                    </div>
                </div>
                <div>
                    <h5 class="mb-1">Model Changes</h5>
                    <h3 class="text-xl font-semibold text-gray-900">327</h3>
                    <div>
                        <span class="inline-block mr-1 text-sm font-semibold text-red-600">-12.6%</span>
                        <span class="inline-block text-sm text-gray-400">Avg Daily: 13</span>
                    </div>
                </div>
                <div>
                    <h5 class="mb-1">Events</h5>
                    <h3 class="text-xl font-semibold text-gray-900">962</h3>
                    <div>
                        <span class="inline-block mr-1 text-sm font-semibold text-green-600">+1.1%</span>
                        <span class="inline-block text-sm text-gray-400">Avg Daily: 35</span>
                    </div>
                </div>
            </div>
            <div class="rounded bg-white w-full py-4 shadow mt-4">
                <div class="px-8 border-b border-gray-200">
                    <h3 class="mb-2 font-medium text-gray-900">Analytics</h3>
                </div>
                <div class="px-8">
                    <canvas id="chart" height="320"></canvas>
                </div>
            </div>
            <div class="-mx-2 flex">
                <div class="rounded bg-white w-1/2 mx-2 py-4 shadow mt-4">
                    <div class="px-8 border-b border-gray-200">
                        <h3 class="mb-2 font-medium text-gray-900">Top Routes<span
                                class="text-sm font-normal text-gray-400 inline-block ml-2">Names</span><span
                                class="text-sm text-blue-500 underline font-medium inline-block ml-2">Paths</span></h3>
                    </div>
                    <div class="px-8">
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 46%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>/</span>
                                <span>581</span>
                            </div>
                        </div>
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 18%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>/login</span>
                                <span>224</span>
                            </div>
                        </div>
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 12%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>/api/users/me</span>
                                <span>145</span>
                            </div>
                        </div>
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 9%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>/api/posts</span>
                                <span>119</span>
                            </div>
                        </div>
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 3%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>/api/comments/create</span>
                                <span>32</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="text-sm text-gray-400">View More</span>
                        </div>
                    </div>
                </div>
                <div class="rounded bg-white w-1/2 mx-2 py-4 shadow mt-4">
                    <div class="px-8 border-b border-gray-200">
                        <h3 class="mb-2 font-medium text-gray-900">Top Events</h3>
                    </div>
                    <div class="px-8">
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 31%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>user.signed-in</span>
                                <span>102</span>
                            </div>
                        </div>
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 21%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>post.created</span>
                                <span>67</span>
                            </div>
                        </div>
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 14%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>comment.created</span>
                                <span>46</span>
                            </div>
                        </div>
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 13%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>user.changed-password</span>
                                <span>41</span>
                            </div>
                        </div>
                        <div class="relative mt-2">
                            <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: 12%"></div>
                            <div class="relative p-2 flex justify-between items-center">
                                <span>api.too-many-requests-reached</span>
                                <span>38</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="text-sm text-gray-400">View More</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded bg-white w-full py-4 shadow mt-4">
                <div class="px-8 pb-2 border-b border-gray-200 flex items-center">
                    <h3 class="font-medium text-gray-900">Model Changes</h3>
                    <div class="ml-2">
                        <span class="inline-block w-2 h-2 bg-blue-500 opacity-50 rounded-full"></span>
                        <span class="text-sm text-gray-400">Created</span>
                    </div>
                    <div class="ml-2">
                        <span class="inline-block w-2 h-2 bg-blue-500 opacity-30 rounded-full"></span>
                        <span class="text-sm text-gray-400">Updated</span>
                    </div>
                    <div class="ml-2">
                        <span class="inline-block w-2 h-2 bg-blue-500 opacity-10 rounded-full"></span>
                        <span class="text-sm text-gray-400">Deleted</span>
                    </div>
                </div>
                <div class="px-8">
                    <div class="mt-2">
                        <div class="flex items-center justify-between mb-1">
                            <h3>User</h3>
                            <span>125</span>
                        </div>
                        <div class="flex w-full h-10">
                            <div class="w-4/12 h-10 bg-blue-500 opacity-50 rounded-l"></div>
                            <div class="w-7/12 h-10 bg-blue-500 opacity-30"></div>
                            <div class="w-1/12 h-10 bg-blue-500 opacity-10 rounded-r"></div>
                        </div>
                    </div>
                </div>
                <div class="px-8">
                    <div class="mt-2">
                        <div class="flex items-center justify-between mb-1">
                            <h3>Post</h3>
                            <span>83</span>
                        </div>
                        <div class="flex w-full h-10">
                            <div class="w-8/12 h-10 bg-blue-500 opacity-50 rounded-l"></div>
                            <div class="w-1/12 h-10 bg-blue-500 opacity-30"></div>
                            <div class="w-3/12 h-10 bg-blue-500 opacity-10 rounded-r"></div>
                        </div>
                    </div>
                </div>
                <div class="px-8">
                    <div class="mt-2 mb-2">
                        <div class="flex items-center justify-between mb-1">
                            <h3>Comment</h3>
                            <span>44</span>
                        </div>
                        <div class="flex w-full h-10">
                            <div class="w-5/12 h-10 bg-blue-500 opacity-50 rounded-l"></div>
                            <div class="w-3/12 h-10 bg-blue-500 opacity-30"></div>
                            <div class="w-4/12 h-10 bg-blue-500 opacity-10 rounded-r"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chart');

        // create a line chart showing requests from the last two weeks, the background color is light blue
        const createGradient = (chart, options) => {
            const gradient = chart.ctx.createLinearGradient(0, 0, 0, ctx.offsetHeight);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)');
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

            chart.data.datasets[0].fill.above = gradient;
        };

        const chart = new Chart(ctx, {
            plugins: [
                {
                    afterLayout: createGradient
                }
            ],
            type: 'line',
            data: {
                labels: ["Jan 21", "Jan 22", "Jan 23", "Jan 24", "Jan 25", "Jan 26", "Jan 27", "Jan 28", "Jan 29", "Jan 30", "Jan 31", "Feb 1", "Feb 2"],
                datasets: [{
                    label: 'Requests',
                    data: [45, 10, 23, 12, 20, 30, 15, 21, 8, 34, 31, 19, 15],
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1,
                    lineTension: 0.2,
                    fill: {
                        target: 'origin'
                    }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        display: true,
                        ticks: {
                            maxTicksLimit: 7
                        },
                        grid: {
                            color: 'rgb(243, 244, 246)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            maxTicksLimit: 5
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>