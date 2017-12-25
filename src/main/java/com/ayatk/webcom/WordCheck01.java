package com.ayatk.webcom;

import javax.servlet.*;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.*;

@WebServlet(name = "WordCheck01", urlPatterns = "/servlet/WordCheck01")
public class WordCheck01 extends HttpServlet {
    private ServletContext sc;

    public void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException {
        try {
            //v Getting servlet-context.
            sc = getServletContext();
            request.setCharacterEncoding("UTF-8");

            String word1Str = request.getParameter("word1");
            String word2Str = request.getParameter("word2");

            String word1StrRvs = new String((new StringBuffer(word1Str)).reverse());

            if (word2Str.equals(word1StrRvs)) {
                sc.getRequestDispatcher("/thanks.html").forward(request, response);
            } else {
                sc.getRequestDispatcher("/error.html").forward(request, response);
            }

        } catch (Exception e1) {
            e1.printStackTrace();
            try {
                sc.getRequestDispatcher("/error.html").forward(request, response);
            } catch (Exception e2) {
                e2.printStackTrace();
            }
        }
    }
}
