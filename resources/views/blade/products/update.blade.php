@extends('app')

@section('content')
    <section class="place-items-center">
        <div class="xs:w-auto sm:w-[450px]">
            <div class="flex items-center justify-between">
                <span class="text-2xl">Update Product</span>
                <a href="{{ route('products.blade') }}" class="primary">Back</a>
            </div>
            <form action="{{ route('products.edit', $productId) }}" method="POST" class="flex flex-col gap-3">
                @csrf
                @method('PUT')
                @foreach ($productObject as $product)
                    <div>
                        <label for="{{ $product['name'] }}">{{ $product['label'] }}<span class="text-red-500">*</span></label>
                        @if ($product['name'] === 'product_category')
                            <div class="relative">
                                <button type="button" class="w-full border border-slate-400 rounded p-2 flex flex-wrap items-center gap-1" id="dropdownButton" aria-haspopup="listbox" aria-expanded="false" aria-controls="dropdownMenu">
                                    <span id="placeholderText" class="text-slate-500">Select Categories</span>
                                </button>
                                <div id="dropdownMenu" class="hidden absolute z-10 bg-white border rounded shadow-lg mt-1 w-full max-h-48 overflow-y-auto" role="listbox" tabindex="-1">
                                    @foreach ($productCategoryData as $category)
                                        <label class="block p-2 cursor-pointer hover:bg-slate-200" role="option" aria-selected="false" for="category-{{ $category->id }}">
                                            <input 
                                                type="checkbox" 
                                                class="category-checkbox mr-1" 
                                                id="category-{{ $category->id }}"
                                                name="product_category[]"
                                                value="{{ $category->id }}"
                                                @if(collect($product['value'])->contains($category->id)) checked @endif
                                            >
                                            <span>{{ $category->category_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error($product['name'])
                                <p class="text-pink-500">{{ $message }}</p>
                            @enderror
                        @elseif ($product['name'] === 'status')
                            <div>
                                <select 
                                    id="{{ $product['name'] }}"
                                    name="{{ $product['name'] }}" 
                                    class="w-full p-2 border border-slate-400 rounded-md"
                                >
                                    <option value="1" @if($product['value'] == 1) selected @endif>Active</option>
                                    <option value="0" @if($product['value'] == 0) selected @endif>Inactive</option>
                                </select>
                            </div>
                        @else
                            <input 
                                type="text" 
                                class="input"
                                name="{{ $product['name'] }}"
                                value="{{ $product['value'] }}"
                            >
                            @error($product['name'])
                                <p class="text-pink-500">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                @endforeach
                <button class="w-full mt-8 success">Save</button>
            </form>
        </div>
    </section>

    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const checkboxes = document.querySelectorAll('.category-checkbox');
        const placeholderText = document.getElementById('placeholderText');

        // Function to update the chips display inside the dropdown button
        function updateButtonChips() {
            // Clear existing chips but keep placeholder
            dropdownButton.querySelectorAll('.chip').forEach(chip => chip.remove());

            const selectedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);

            if (selectedCheckboxes.length === 0) {
                placeholderText.style.display = 'inline';
                dropdownButton.setAttribute('aria-expanded', 'false');
            } else {
                placeholderText.style.display = 'none';
                dropdownButton.setAttribute('aria-expanded', 'true');
            }

            selectedCheckboxes.forEach(cb => {
                const label = cb.parentNode.textContent.trim();

                // Create chip span
                const chip = document.createElement('span');
                chip.className = 'chip flex items-center bg-blue-100 text-blue-800 rounded-full px-2 py-0.5 text-xs select-none';
                chip.style.userSelect = 'none';
                chip.textContent = label;

                // Create remove icon
                const removeIcon = document.createElement('button');
                removeIcon.type = 'button';
                removeIcon.setAttribute('aria-label', `Remove ${label}`);
                removeIcon.className = 'ml-1 text-blue-600 hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded-full';
                removeIcon.innerHTML = '&times;'; // × symbol
                removeIcon.style.fontWeight = 'bold';
                removeIcon.style.lineHeight = '1';

                // On clicking remove icon, uncheck the checkbox and update
                removeIcon.addEventListener('click', (event) => {
                    event.stopPropagation(); // prevent dropdown toggle
                    cb.checked = false;
                    updateButtonChips();
                });

                chip.appendChild(removeIcon);
                dropdownButton.appendChild(chip);
            });
        }

        // Initial update
        updateButtonChips();

        // Toggle dropdown menu
        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', event => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Update chips when checkboxes change
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateButtonChips);
        });
    </script>

    <style>
        /* Chip style */
        .chip {
            cursor: default;
        }
        .chip button {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            line-height: 1;
            padding-left: 0.25rem;
        }
        .chip button:hover {
            color: #1D4ED8; /* stronger blue on hover */
        }
    </style>
@endsection

