<script type="text/javascript">
    @if (Session::get('success'))
        toastr.success('{{ Session::get('success') }}', 'Successful');
    @endif
    @if (Session::get('error'))
        toastr.error('{{ Session::get('error') }}', 'Error');
    @endif
    @if (count($errors) > 0)
        // console.log('{!! implode('<br>', $errors->all()) !!}');
        toastr.error('{!! implode('<br>', $errors->all()) !!}', 'Error');
    @endif

    function copyFunction(element) {
        var aux = document.createElement("input");
        // Assign it the value of the specified element
        aux.setAttribute("value", element);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);

        toastr.info('Copied Successfully', "Success");
    }

    window.addEventListener('alert', event => {
        event.detail.forEach(({ type, message, title }) => {
            toastr[type](message, title ?? 'Successful');
        });
    });
    document.addEventListener('livewire:navigating', () => {
        JDLoader.open('.loader-mask');
    })
    document.addEventListener('livewire:navigated', () => {
        JDLoader.close('.loader-mask');

        const currentUrl = window.location.href.split(/[?#]/)[0];
        const navItems = document.querySelectorAll('.nav-menu__item');

        navItems.forEach(item => {
            const link = item.querySelector('a');
            if (!link) return;

            const linkPath = new URL(link.href);

            if (linkPath == currentUrl) {
                item.classList.add('activePage');
            } else {
                item.classList.remove('activePage');
            }
        });
    })

    function openLink(url, target = '_self') {
        window.open(url, target);
    }
</script>
