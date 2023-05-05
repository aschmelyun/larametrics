<header class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-900 mb-0">Overview</h1>
    <form action="">
        <select id="days" name="days" onchange="this.form.submit()" class="rounded bg-white border border-gray-300 text-gray-500 text-sm font-semibold px-4 py-2">
            <option value="1" @selected(request()->get('days') == 1)>Last 24 hours</option>
            <option value="7" @selected(request()->get('days') == 7)>Last 7 days</option>
            <option value="30" @selected(request()->get('days') == 30)>Last 30 days</option>
            <option value="90" @selected(request()->get('days') == 90)>Last 90 days</option>
            <option value="365" @selected(request()->get('days') == 365)>Last year</option>
        </select>
    </form>
</header>