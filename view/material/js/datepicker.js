let picker = null
const DateTime = easepick.DateTime;


function getBookedDates(material)
{
    let bookedDates = []

    APIcallPOST('https://asaed4.gremmi.fr/api/cart/list', {"id_material":material})
        .then((response) => {
            var datas = JSON.parse(response);
            datas = datas.data;
            for (let data of datas) {
                const formattedBeginDate = data.date_begin.split(' ')[0]; // Récupérer la partie de la date avant l'espace
                const formattedEndDate = data.date_end.split(' ')[0]; // Récupérer la partie de la date avant l'espace
                bookedDates.push([formattedBeginDate, formattedEndDate]);
            }
            console.log(bookedDates)
            printCalendar(bookedDates, material)
        })
        .catch((error) => {
            console.error(error);
        });
}

function printCalendar(bookedDates, material)
{
    bookedDates = bookedDates.map(d => {
        if (d instanceof Array) {
            const start = new DateTime(d[0], 'YYYY-MM-DD');
            const end = new DateTime(d[1], 'YYYY-MM-DD');

            return [start, end];
        }

        return new DateTime(d, 'YYYY-MM-DD');
    });
    const picker = new easepick.create({
        element: datepickerInput,
        autoApply:false,
        css: [
            'https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css',
            'https://easepick.com/css/demo_hotelcal.css',
        ],
        plugins: ['RangePlugin', 'LockPlugin'],
        RangePlugin: {
            tooltipNumber(num) {
                return num - 1;
            },
            locale: {
                one: 'jour',
                other: 'jours',
            },
        },
        LockPlugin: {
            minDate: new Date(),
            minDays: 2,
            inseparable: true,
            filter(date, picked) {
                if (picked.length === 1) {
                    const incl = date.isBefore(picked[0]) ? '[)' : '(]';
                    return !picked[0].isSame(date, 'day') && date.inArray(bookedDates, incl);
                }

                return date.inArray(bookedDates, '[)');
            },
        }
    });

    picker.show()
    picker.on('select', () => {
        const dateRange = datepickerInput.value;
        const [dateBegin, dateEnd] = dateRange.split(' - ');

        dates.push(dateBegin, dateEnd)
        console.log('dates:' + dates)
        MaterialGlobalChecker(material)
    })
}