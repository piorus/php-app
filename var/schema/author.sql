DROP TABLE IF EXISTS "author";
CREATE TABLE "author" (
                        id SERIAL PRIMARY KEY,
                        first_name varchar(255) NOT NULL,
                        last_name varchar(255) NOT NULL,
                        bio TEXT NOT NULL
);
INSERT INTO "author" (first_name, last_name, bio) VALUES ('Gary', 'Bencivenga', 'Gary spent the last 38 years painstakingly collecting and applying every secret he could find to help America’s leading direct marketers achieve breakthrough response.

He broke into direct marketing working with Hall-of-Fame copywriters John Caples at BBDO and later David Ogilvy at Ogilvy & Mather, both of whom taught him quite a few tricks for systematically beating almost any control, even the strong ones.

After them, he was blessed to work with a series of tough-as-sandpaper copy chiefs and smart-as-a-whip clients, including Ted Nicholas and Max Sackheim, who taught him their battle-tested secrets for beating control packages and space ads.

Over the years, he supervised literally thousands of split-run tests and collected—like beautiful butterflies—the most powerful techniques to use in headlines, offers, formats, copy and design of direct response advertising.');
