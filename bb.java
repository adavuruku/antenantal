public String getCountOfDays(String createdDateString, String expireDateString) {
    SimpleDateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy", Locale.getDefault());

    Date createdConvertedDate = null, expireCovertedDate = null, todayWithZeroTime = null;
    try {
        createdConvertedDate = dateFormat.parse(createdDateString);
        expireCovertedDate = dateFormat.parse(expireDateString);

        Date today = new Date();

        todayWithZeroTime = dateFormat.parse(dateFormat.format(today));
    } catch (ParseException e) {
        e.printStackTrace();
    }

    int cYear = 0, cMonth = 0, cDay = 0;

    if (createdConvertedDate.after(todayWithZeroTime)) {
        Calendar cCal = Calendar.getInstance();
        cCal.setTime(createdConvertedDate);
        cYear = cCal.get(Calendar.YEAR);
        cMonth = cCal.get(Calendar.MONTH);
        cDay = cCal.get(Calendar.DAY_OF_MONTH);

    } else {
        Calendar cCal = Calendar.getInstance();
        cCal.setTime(todayWithZeroTime);
        cYear = cCal.get(Calendar.YEAR);
        cMonth = cCal.get(Calendar.MONTH);
        cDay = cCal.get(Calendar.DAY_OF_MONTH);
    }


    /*Calendar todayCal = Calendar.getInstance();
    int todayYear = todayCal.get(Calendar.YEAR);
    int today = todayCal.get(Calendar.MONTH);
    int todayDay = todayCal.get(Calendar.DAY_OF_MONTH);
    */

    Calendar eCal = Calendar.getInstance();
    eCal.setTime(expireCovertedDate);

    int eYear = eCal.get(Calendar.YEAR);
    int eMonth = eCal.get(Calendar.MONTH);
    int eDay = eCal.get(Calendar.DAY_OF_MONTH);

    Calendar date1 = Calendar.getInstance();
    Calendar date2 = Calendar.getInstance();

    date1.clear();
    date1.set(cYear, cMonth, cDay);
    date2.clear();
    date2.set(eYear, eMonth, eDay);

    long diff = date2.getTimeInMillis() - date1.getTimeInMillis();

    float dayCount = (float) diff / (24 * 60 * 60 * 1000);

    return ("" + (int) dayCount + " Days");
}


public String monthsBetweenDates(String startDate){
    SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd",Locale.getDefault());
    Calendar startCalender = Calendar.getInstance();
    Calendar todayCalender = Calendar.getInstance();
    try {
        startCalender.setTime(sdf.parse(startDate));
        
        Date today = new Date();
        Date todayWithZeroTime = sdf.parse(sdf.format(today));
        todayCalender.setTime(todayWithZeroTime);

    } catch (ParseException e) {
        e.printStackTrace();
    }

    int sYear = startCalender.get(Calendar.YEAR);
    int sMonth = startCalender.get(Calendar.MONTH);
    int sDay = startCalender.get(Calendar.DAY_OF_MONTH);

    int tYear = todayCalender.get(Calendar.YEAR);
    int tMonth = todayCalender.get(Calendar.MONTH);
    int tDay = todayCalender.get(Calendar.DAY_OF_MONTH);

    System.out.println("Start " +startCalender);
    System.out.println("Today " + todayCalender);

 
    Calendar date1 = Calendar.getInstance();
    Calendar date2 = Calendar.getInstance();

    date1.clear();
    date1.set(sYear, sMonth, sDay);
    date2.clear();
    date2.set(tYear, tMonth, tDay);

    long diff = date2.getTimeInMillis() - date1.getTimeInMillis();

    float dayCount = (float) diff / (24 * 60 * 60 * 1000);

    return  dayCount + " Days";
}